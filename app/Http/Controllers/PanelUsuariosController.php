<?php

namespace App\Http\Controllers;
#CLASES

use App\Models\Actividad;
use App\Models\Comentarios;
use App\Models\Contenidos;
use App\Models\DatosPersonales;
use App\Models\HistorialUsuario;
use App\Models\Imagenes;
use App\Models\ImagenesContenido;
use App\Models\Interacciones;
use App\Models\Notificaciones;
use App\Models\Reportes;
use App\Models\RevisionImagenes;
use App\Models\Roles;
use App\Models\StaffExtra;
use App\Models\TipodeStaff;
use App\Models\Usuario;

#Otros
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PanelUsuariosController extends Controller
{
    #Lista los usuarios Fans y SuperFans.
    public function listar(Request $request)
    {
        // Cargar los usuarios con los datos personales y la imagen de perfil
        $query = Usuario::whereIn('rol_idrol', [3, 4])
            ->whereHas('datosPersonales.historialUsuario', function ($q) {
                $q->where('estado', '!=', 'Inactivo');
            })
            ->with([
                'revisionImagenes' => function ($query) {
                    // Filtrar para traer solo la imagen de perfil (idtipodefoto = 1)
                    $query->where('tipodefoto_idtipodefoto', 1)->with('imagenes');
                },
                'datosPersonales'
            ]);

        // Filtro de búsqueda
        if ($request->has('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function ($q) use ($busqueda) {
                $q->where('usuarioUser', 'like', '%' . $busqueda . '%')
                    ->orWhere('correoElectronicoUser', 'like', '%' . $busqueda . '%');
            });
        }

        // Paginación de usuarios
        $perPage = $request->input('per_page', 6); // 6 es el valor predeterminado
        return $usuarios = $query->paginate($perPage);
    }

    #Mira la imagenes de cada usuario y pasamos ruta si existe
    public function mirar($usuarioId)
    {
        $existeFoto = RevisionImagenes::where('usuarios_idusuarios', $usuarioId)
            ->where('tipoDeFoto_idtipoDeFoto', 1)
            ->first();

        if ($existeFoto) {
            $idParaURL = $existeFoto->imagenes_idimagenes;
            $imagen = Imagenes::find($idParaURL);
            return $imagen ? asset(Storage::url($imagen->subidaImg)) : asset('img/logo_usuario.webp');
        } else {
            return asset('img/logo_usuario.webp');
        }
    }

    #Envia a la vista
    public function panel(Request $request)
    {
        $funciona = true; // Inicializamos como true

        // Obtener los usuarios que no son administradores
        $usuarios = Usuario::where('rol_idrol', '!=', 1)->get();

        if ($usuarios->isEmpty()) {
            $funciona = false;
            return view('profile.panelUsuarios', ['funciona' => $funciona]);
        }

        // Obtener la lista de usuarios utilizando la función listar
        $usuarios = $this->listar($request);

        // Obtener roles y especialidades desde la base de datos
        $roles = Roles::where('rol', '!=', 'Administrador')->get();
        $especialidades = TipodeStaff::all();

        // Obtener el usuario autenticado y su rol
        $usuarioAutenticado = Auth::user();
        $rol = $usuarioAutenticado->rol_idrol;

        // Inicializar la lista de reportados y la variable $id
        $listaReportado = [];
        $id = null; // Asegura que siempre esté definida

        foreach ($usuarios as $usuario) {
            if ($usuario) {
                // Asignar el ID del usuario
                $id = $usuario->idusuarios;

                // Asignar la URL de la imagen al usuario
                $usuario->urlImagen = $this->mirar($id);

                // Obtener las actividades del usuario
                $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

                // Inicializar contador de reportes para este usuario
                $totalReportes = 0;

                // Recorrer las actividades y contar los reportes
                foreach ($actividades as $actividad) {
                    $reporteCount = Interacciones::where('actividad_idActividad', $actividad->idActividad)
                        ->where('reporte', '>', 0)
                        ->count();

                    $totalReportes += $reporteCount;
                }

                // Guardar el total de reportes del usuario en la lista
                $listaReportado[$id] = $totalReportes;
            }
        }

        // Si no se encontró ningún ID, cambiar $funciona a false
        if (is_null($id)) {
            $funciona = false;
        }

        // Retornar la vista con los datos necesarios
        return view('profile.panelUsuarios', [
            'funciona' => $funciona,
            'usuarios' => $usuarios,
            'roles' => $roles,
            'rol' => $rol,
            'especialidades' => $especialidades,
            'id' => $id, // Puede ser null si no hay usuarios
            'listaReportado' => $listaReportado,
        ]);
    }



    #Envia a la vista usuariotabla
    public function buscarUsuarios(Request $request)
    {
        $usuarios = $this->listar($request);
        // Retornar la tabla de usuarios para ser renderizada
        return view('profile.partials.usuarios-table', ['usuarios' => $usuarios])->render();
    }

    #Modifica rol
    public function modificarRol(Request $request, $id)
    {
        $request->validate([
            'rol' => 'required|integer',
            'especialidad' => 'nullable|integer',
        ]);

        // Encontrar el usuario
        $usuario = Usuario::find($id);

        // Actualizar el rol del usuario
        $nuevoRol = $request->rol;
        $usuario->rol_idrol = $nuevoRol;
        $usuario->save();

        // Si el rol nuevo pertenece a Staff (2), guardar la especialidad en StaffExtra
        if ($nuevoRol == 2) {
            // Verificar si ya existe un registro en StaffExtra para este usuario
            $staffExtra = StaffExtra::firstOrNew(['usuarios_idusuarios' => $usuario->idusuarios]);

            // Asignar la especialidad seleccionada y una imagen por defecto si no existe
            $staffExtra->tipoStaff_idtipoStaff = $request->input('especialidad');

            // Guardar o actualizar el registro
            $staffExtra->save();
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('panel-de-usuarios')->with('alertEliminacion', [
            'type' => 'Success',
            'message' => 'El rol fue actualizado con éxito!',
        ]);
    }

    public function borrarImagen($id)
    {
        $eliminado = $this->eliminarImagen($id);

        if ($eliminado) {
            return redirect()->route('panel-de-usuarios')->with('alertEliminacion', [
                'type' => 'Success',
                'message' => 'Imagen eliminada exitosamente',
            ]);
        } else {
            return redirect()->route('panel-de-usuarios')->with('alertEliminacion', [
                'type' => 'Danger',
                'message' => 'No se encontró la imagen o no se pudo eliminar',
            ]);
        }
    }

    public function eliminarImagen($id)
    {
        $existeFoto = RevisionImagenes::where('usuarios_idusuarios', $id)
            ->where('tipoDeFoto_idtipoDeFoto', 1)
            ->first();

        if ($existeFoto) {
            $imagen = Imagenes::find($existeFoto->imagenes_idimagenes);

            $existeFoto->delete();

            if ($imagen) {
                if (Storage::exists($imagen->subidaImg)) {
                    Storage::delete($imagen->subidaImg);
                }
                $imagen->delete();
            }
            return true;
        }

        return false;
    }

    #Eliminar Revision e Imagenes
    private function eliminarImagenYRevision($revisionImagenId)
    {
        if ($revisionImagenId) {
            $revisionImagen = RevisionImagenes::find($revisionImagenId);
            if ($revisionImagen) {
                // Eliminar la revisión de la imagen
                $revisionImagen->delete();

                // Eliminar la imagen asociada
                if ($revisionImagen->imagenes_idimagenes) {
                    $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);
                    if ($imagen) {
                        // Eliminar la imagen del almacenamiento
                        Storage::disk('public')->delete($imagen->subidaImg);
                        // Eliminar la imagen de la base de datos
                        $imagen->delete();
                    }
                }
            }
        }
    }

    // Eliminar el usuario en cascada
    public function eliminarUsuario($id)
    {
        // Encontrar al usuario
        $usuario = Usuario::find($id);

        // Verificar si el usuario tiene reportes asociados (aquí asumo que tienes un atributo 'reportes')
        $tieneReportes = Reportes::where('usuarios_idusuarios', $id)->get();

        // Relaciono a su usuario con datos personales
        $datospersonales = DatosPersonales::where('usuarios_idusuarios', $id)->first();

        // Verificamos si existen los datos personales
        if ($datospersonales) {
            // Actualizo el Historial Usuario
            $historial = HistorialUsuario::where('datospersonales_idDatosPersonales', $datospersonales->idDatosPersonales)->first();
            if ($historial) {
                $historial->estado = "Inactivo";
                $historial->eliminacionLogica = 'Si';
                //fechaFinaliza el dia
                $historial->fechaFinaliza = date('Y-m-d');
                $historial->save();
            }

            // Aquí deberías borrar la contraseña del usuario de manera segura
            $usuario->contraseniaUser = null;
            $usuario->usuarioUser = null;
            $usuario->save();
        }

        //Eliminamos notificacoines del usuario
        $notificaciones = Notificaciones::where('usuarios_idusuarios', $id)->delete();

        if ($tieneReportes === 0) {
            // Si no hay reportes, eliminamos al usuario de la tabla
            Reportes::where('usuarios_idusuarios', $id)->delete();
        }

        // Elimino todas las interacciones que realizó el usuario
        Interacciones::where('usuarios_idusuarios', $id)->delete();

        // Accedo a todas las actividades realizadas por el usuario
        $actividades = Actividad::where('usuarios_idusuarios', $id)->with(['comentarios', 'contenidos'])->get();
        foreach ($actividades as $actividad) {
            // Eliminar las interacciones de esa actividad
            Interacciones::where('Actividad_idActividad', $actividad->idActividad)->delete();

            // Eliminar los comentarios
            foreach ($actividad->comentarios as $comentario) {
                // Eliminar las interacciones del comentario
                Interacciones::where('Actividad_idActividad', $comentario->Actividad_idActividad)->delete();

                // Eliminar la imagen asociada al comentario
                if ($comentario->revisionImagenes_idrevisionImagenescol) {
                    // Eliminar el comentario primero
                    $comentario->delete();
                    // Ahora elimina la revisión de imagen asociada
                    $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
                } else {
                    // Solo elimina el comentario si no tiene revisión
                    $comentario->delete();
                }
            }

            // Eliminar los contenidos
            foreach ($actividad->contenidos as $contenido) {
                foreach ($contenido->comentarios as $comentario) {
                    Interacciones::where('Actividad_idActividad', $comentario->Actividad_idActividad)->delete();
                    $comentario->delete();
                    $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
                    // Eliminar la actividad del comentario de la tabla actividad
                    Actividad::where('idActividad', $comentario->Actividad_idActividad)->delete();
                }

                // Eliminar imágenes de contenido y sus revisiones
                foreach ($contenido->imagenesContenido as $imagenContenido) {
                    $imagenContenido->delete();
                    $this->eliminarImagenYRevision($imagenContenido->revisionImagenes_idrevisionImagenescol);
                }

                // Eliminar el contenido
                $contenido->delete();
            }

            // Después de eliminar los contenidos y comentarios, eliminar la actividad
            $actividad->delete();
        }

        // Borramos la imagen de perfil si tiene
        $eliminado = $this->eliminarImagen($id);

        return redirect()->back()->with('alertBorrar', [
            'type' => 'Success',
            'message' => 'Se ha borrado al Usuario con exito!',
        ]);
    }
}

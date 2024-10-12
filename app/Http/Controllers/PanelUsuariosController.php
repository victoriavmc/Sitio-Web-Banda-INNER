<?php

namespace App\Http\Controllers;
#CLASES

use App\Models\Actividad;
use App\Models\Comentarios;
use App\Models\Contenidos;
use App\Models\DatosPersonales;
use App\Models\HistorialUsuario;
use App\Models\Imagenes;
use App\Models\Interacciones;
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
            return $imagen ? asset(Storage::url($imagen->subidaImg)) : asset('img/logo_usuario.png');
        } else {
            return asset('img/logo_usuario.png');
        }
    }

    #Envia a la vista
    public function panel(Request $request)
    {
        // Obtener la lista de usuarios
        $usuarios = $this->listar($request);

        // Obtener los roles desde la base de datos
        $roles = Roles::where('rol', '!=', 'Administrador')->get();

        $especialidades = TipodeStaff::all();

        // Obtener el usuario autenticado
        $usuarioAutenticado = Auth::user();
        $rol = $usuarioAutenticado->rol_idrol;

        // Asignar la URL de la imagen a cada usuario
        foreach ($usuarios as $usuario) {
            // Asegúrate de que el usuario tiene un método o propiedad que te permita obtener la URL de la imagen
            $id = $usuario->idusuarios;
            $usuario->urlImagen = $this->mirar($usuario->idusuarios);
        }

        // Retornar la vista con los usuarios, roles y el rol del usuario autenticado
        return view('profile.panelUsuarios', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'rol' => $rol,
            'especialidades' => $especialidades,
            'id' => $id
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
            $staffExtra->imagenes_idimagenes = 78;

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
        $tieneReportes = Reportes::where('usuarios_idusuarios', $id)->value('reportes');

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
            $usuario->save();
        }

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


    #REPORTES

    #Busco Imagen de un Usuario Especifico (VER COMO USAR)
    public function buscarImagen($idUser)
    {
        // Ahora busco en la tabla revisionImagenes
        $imagenPerfil = RevisionImagenes::where('usuarios_idusuarios', $idUser)
            ->where('tipodefoto_idtipoDeFoto', 1)
            ->first();

        if ($imagenPerfil) {
            $idImagenP = $imagenPerfil->imagenes_idimagenes;

            // Ahora busco la imagen en la tabla imagenes
            $ubicacionImagen = Imagenes::where('idimagenes', $idImagenP)->first();

            return $ubicacionImagen ? $ubicacionImagen->subidaImg : null;
        }

        return null; // Si no hay imagen
    }

    #Redirigir a manejoreporte
    public function manejoreporte($id)
    {
        // Usuario
        $usuario = Usuario::find($id);

        // Datos personales
        $datosPersonales = $usuario->datosPersonales;

        // Reportes
        $reportes = $usuario->reportes;

        $imagen = $this->buscarImagen($id);


        // Mostrar Actividades en general del usuario
        $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

        // Almacenar datos de las actividades reportadas y no reportadas
        $listaActividadReportadaComentario = [];
        $listaActividadReportadaContenido = [];
        $listaActividadNOReportadaComentario = [];
        $listaActividadNOReportadaContenido = [];

        // Actividad x actividad
        foreach ($actividades as $actividad) {
            // Obtener el ID de la actividad actual
            $actividadId = $actividad->idActividad;
            $tipoActividad = $actividad->tipoActividad_idtipoActividad;

            // Mostrar actividad específica: contar reportes
            $reportes = Interacciones::where('actividad_idActividad', $actividadId)
                ->where('reporte', '>', 0)
                ->select(DB::raw('COUNT(*) as totalReportes'))
                ->first();

            // Verificamos si hay reportes
            if ($reportes && $reportes->totalReportes > 0) {
                switch ($tipoActividad) {
                    case '1':
                        // Reportaron el Perfil
                        break;

                    case '2':
                        // Obtener comentarios relacionados a la actividad
                        $comentarios = Comentarios::where('Actividad_idActividad', $actividadId)->get();

                        // Recorrer los comentarios y almacenarlos en la lista
                        foreach ($comentarios as $comentario) {
                            $contenido = Contenidos::find($comentario->contenidos_idcontenidos); // Obtener el contenido relacionado

                            $listaActividadReportadaComentario[] = [
                                'idComentario' => $comentario->idcomentarios,
                                'fechaComent' => $comentario->fechaComent,
                                'descripcion' => $comentario->descripcion,
                                'tituloContenido' => $contenido ? $contenido->titulo : null, // Agregar título del contenido
                                'reportado' => true, // Marcamos como reportado
                            ];
                        }
                        break;

                    case '3':
                        // Reportaron el contenido  
                        // Obtener contenidos relacionados a la actividad
                        $contenidos = Contenidos::where('Actividad_idActividad', $actividadId)->get(); // Obtener todos los contenidos relacionados

                        foreach ($contenidos as $contenido) {
                            $listaActividadReportadaContenido[] = [
                                'fechaComent' => $contenido->fechaSubida,
                                'titulo' => $contenido->titulo,
                                'descripcion' => $contenido->descripcion,
                                'reportado' => true, // Marcamos como reportado
                            ];
                        }
                        break;
                }
            } else {
                // Si no hay reportes

                switch ($tipoActividad) {
                    case '2':
                        // Obtener comentarios no reportados
                        $comentarios = Comentarios::where('Actividad_idActividad', $actividadId)->get();

                        foreach ($comentarios as $comentario) {
                            $contenido = Contenidos::find($comentario->contenidos_idcontenidos); // Obtener contenido relacionado

                            $listaActividadNOReportadaComentario[] = [
                                'idComentario' => $comentario->idcomentarios,
                                'fechaComent' => $comentario->fechaComent,
                                'descripcion' => $comentario->descripcion,
                                'tituloContenido' => $contenido ? $contenido->titulo : null, // Título del contenido
                                'reportado' => false, // Marcado como no reportado
                            ];
                        }
                        break;

                    case '3':
                        // Obtener contenidos no reportados
                        $contenidos = Contenidos::where('Actividad_idActividad', $actividadId)->get();

                        foreach ($contenidos as $contenido) {
                            $listaActividadNOReportadaContenido[] = [
                                'fechaComent' => $contenido->fechaSubida,
                                'titulo' => $contenido->titulo,
                                'descripcion' => $contenido->descripcion,
                                'reportado' => false, // Marcado como no reportado
                            ];
                        }
                        break;
                }
            }
        }

        // Después del bucle calcular el total de actividades no reportadas
        $totalNoReportadas = count($listaActividadNOReportadaComentario) + count($listaActividadNOReportadaContenido);

        return view('profile.manejoreporte', compact(
            'usuario',
            'datosPersonales',
            'imagen',
            'actividades',
            'reportes',
            'listaActividadReportadaComentario',
            'listaActividadReportadaContenido',
            'listaActividadNOReportadaComentario',
            'listaActividadNOReportadaContenido',
            'totalNoReportadas' // Pasar el total correctamente
        ));
    }
}

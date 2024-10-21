<?php

namespace App\Http\Controllers;

#Clases

use App\Models\Actividad;
use App\Models\DatosPersonales;
use App\Models\HistorialUsuario;
use App\Models\Usuario;
use App\Models\RevisionImagenes;
use App\Models\Imagenes;
use App\Models\Interacciones;
use App\Models\Reportes;
use App\Models\Roles;
use App\Models\StaffExtra;
use App\Models\TipodeStaff;

#Otros
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class panelStaffController extends Controller
{
    #Lista a los miembros del Staff
    public function listar(Request $request)
    {
        // Cargar los usuarios con los datos personales, imagen de perfil y estado
        $query = Usuario::where('rol_idrol', 2) // Filtrar por el rol específico (id 2)
            ->with([
                'revisionImagenes' => function ($query) {
                    // Filtrar para traer solo la imagen de perfil (idtipodefoto = 1)
                    $query->where('tipodefoto_idtipodefoto', 1)->with('imagenes');
                },
                'datosPersonales',
                'staffextra',
                'datosPersonales.historialUsuario' // Relación con historialUsuario para obtener el estado
            ]);

        // Filtro de búsqueda
        if ($request->has('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function ($q) use ($busqueda) {
                $q->where('usuarioUser', 'like', '%' . $busqueda . '%')
                    ->orWhere('correoElectronicoUser', 'like', '%' . $busqueda . '%');
            });
        }

        // Ordenar primero por estado (Activo primero, luego Inactivo)
        $query->join('historialusuario', 'usuarios.idusuarios', '=', 'historialusuario.datospersonales_idDatosPersonales') // Join con historial_usuario
            ->orderByRaw("CASE WHEN historialusuario.estado = 'Activo' THEN 1 ELSE 2 END");

        // Paginación de usuarios
        $usuarios = $query->paginate(6);

        // Verificar si hay usuarios
        if ($usuarios->isEmpty()) {
            return false;
        }
        return $usuarios;
    }

    #Visualiza a los miembros del Staff
    public function panel(Request $request)
    {
        $funciona = true;

        // Obtener los roles desde la base de datos
        $roles = Roles::where('rol', '!=', 'Administrador')->get();
        $usuariostabla = Usuario::with('staffExtra.tipoStaff')->get();

        // Obtener el usuario autenticado
        $usuarioAutenticado = Auth::user();
        $rol = $usuarioAutenticado->rol_idrol;

        // Obtener todas las especialidades
        $especialidadModal = TipodeStaff::all();

        // Obtener la lista de usuarios
        $usuarios = $this->listar($request);

        $funcion = true;
        if ($usuarios != false) {
            // Asignar imágenes y especialidades a los usuarios
            foreach ($usuarios as $usuario) {
                $usuario->urlImagen = $this->mirar($usuario->idusuarios);

                // Obtener la especialidad del usuario
                $obtenerEspecificoUser = StaffExtra::where('usuarios_idusuarios', $usuario->idusuarios)->first();
                if ($obtenerEspecificoUser) {
                    $especialidad = TipodeStaff::find($obtenerEspecificoUser->tipoStaff_idtipoStaff);
                    $usuario->especialidad = $especialidad ? $especialidad->nombre : 'Sin especialidad';
                } else {
                    $usuario->especialidad = 'Sin especialidad';
                }

                # REPORETE
                // Obtener todas las actividades del usuario
                $actividades = Actividad::where('usuarios_idusuarios', $usuario->idusuarios)->get();

                // Contabilizar el número total de reportes en las actividades del usuario
                $totalReportes = 0;

                foreach ($actividades as $actividad) {
                    // Contar las interacciones de tipo reporte para cada actividad
                    $reporteCount = Interacciones::where('actividad_idActividad', $actividad->idActividad)
                        ->where('reporte', '>', 0)
                        ->count();

                    // Sumar al total de reportes del usuario
                    $totalReportes += $reporteCount;
                }

                // Guardar el número total de reportes en la lista
                $listaReportado[$usuario->idusuarios] = $totalReportes;
            }

            return view('profile.panelStaff', [
                'funcion' => $funcion,
                'usuarios' => $usuarios,
                'roles' => $roles,
                'rol' => $rol,
                'especialidadModal' => $especialidadModal,
                'usuariostabla' => $usuariostabla,
                'listaReportado' => $listaReportado,
            ]);
        } else {
            $funcion = false;
            return view('profile.panelStaff', compact('funcion'));
        }
    }

    #Buscamos y enviamos a la vista Usuario especifico
    public function buscarUsuarios(Request $request)
    {
        $usuarios = $this->listar($request);
        // Retornar la tabla de staff para ser renderizada
        return view('profile.partials.staff-table', ['usuarios' => $usuarios])->render();
    }

    #Miramos Imagen Especifica, enviamos la ruta
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

    #Modificamos el rol
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

            // Guardar o actualizar el registro
            $staffExtra->save();
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('panel-de-staff')->with('alertEliminacion', [
            'type' => 'Success',
            'message' => 'El rol fue actualizado con éxito!',
        ]);
    }

    # Borramos imagenes del Staff
    public function borrarImagenStaff($id)
    {
        // Eliminar la imagen del usuario
        $existeFoto = RevisionImagenes::where('usuarios_idusuarios', $id)->where('tipoDeFoto_idtipoDeFoto', 1)->first();
        if ($existeFoto != null) {
            // Obtener el registro de la imagen anterior
            $imagen = Imagenes::find($existeFoto->imagenes_idimagenes);

            // Eliminar el registro de la revisión anterior
            $existeFoto->delete();

            // Eliminar el archivo del almacenamiento y el registro de la imagen anterior
            if ($imagen && Storage::exists($imagen->subidaImg)) {
                Storage::delete($imagen->subidaImg);
            }

            // Ahora eliminar el registro de la imagen anterior
            $imagen->delete();
            return redirect()->route('panel-de-staff')->with('alertEliminacion', [
                'type' => 'Success',
                'message' => 'Imagen eliminada exitosamente',
            ]);
        } else {
            return redirect()->route('panel-de-staff')->with('alertEliminacion', [
                'type' => 'Danger',
                'message' => 'No se pudo eliminar la imagen por defecto del staff',
            ]);
        }
    }

    # Eliminar miembro del Staff
    public function eliminarStaff($id)
    {
        // Como es un miembro del staff, es decir un trabajador guardamos todo lo que realizo, y no eliminamos, solo vamos a eliminar la redsocial, la foto de perfil, pero guardamos todo lo que hizo. 

        // Encontrar al usuario
        $usuario = Usuario::find($id);

        // Relaciono a su usuario con datos personales
        $datospersonales = DatosPersonales::where('usuarios_idusuarios', $id)->first();

        // Verificamos si existen los datos personales
        if ($datospersonales) {
            // Actualizo el Historial Usuario
            $historial = HistorialUsuario::where('datospersonales_idDatosPersonales', $datospersonales->idDatosPersonales)->first();
            if ($historial) {
                $historial->estado = "Inactivo";
                $historial->eliminacionLogica = 'Si';
                $historial->fechaFinaliza = date('Y-m-d');
                $historial->save();
            }

            // Aquí deberías borrar la contraseña del usuario de manera segura
            $usuario->contraseniaUser = null;
            $usuario->usuarioUser = null;
            $usuario->save();

            #Borro solo el atributo de redSocial enlazada en la tabla staffextra
            $staffextra = StaffExtra::where('usuarios_idusuarios', $id)->first();
            if ($staffextra) {
                $staffextra->redesSociales_idredesSociales = null;
                $staffextra->save();
            }
        }

        // Verificar si el usuario tiene reportes asociados (aquí asumo que tienes un atributo 'reportes')
        $tieneReportes = Reportes::where('usuarios_idusuarios', $id)->first();

        if (!$tieneReportes) {
            // Si no hay reportes, eliminamos al usuario de la tabla
            Reportes::where('usuarios_idusuarios', $id)->delete();
        }

        #Eliminar en CASCADA
        return redirect()->route('panel-de-staff')->with('alertEliminacion', [
            'type' => 'Success',
            'message' => 'La cuenta y la imagen fueron eliminadas con éxito',
        ]);
    }

    #Redirigir a manejoreporte
    public function manejoreporte($id)
    {
        $usuario = Usuario::find($id);
        return view('profile.manejoreporte', compact('usuario'));
    }
}

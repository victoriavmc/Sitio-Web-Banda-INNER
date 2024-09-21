<?php

namespace App\Http\Controllers;

#Clases
use App\Models\Usuario;
use App\Models\RevisionImagenes;
use App\Models\Imagenes;
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
        // Cargar los usuarios con los datos personales y la imagen de perfil
        $query = Usuario::where('rol_idrol', 2)
            ->with([
                'revisionImagenes' => function ($query) {
                    // Filtrar para traer solo la imagen de perfil (idtipodefoto = 1)
                    $query->where('tipodefoto_idtipodefoto', 1)->with('imagenes');
                },
                'datosPersonales',
                'staffextra'
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
        return $usuarios = $query->paginate(6);
    }

    #Visualiza a los miembros del Staff
    public function panel(Request $request)
    {
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
        }

        return view('profile.panelStaff', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'rol' => $rol,
            'especialidadModal' => $especialidadModal,
            'usuariostabla' => $usuariostabla,
        ]);
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
        // Encontrar al usuario
        $usuario = Usuario::find($id);

        #Eliminar en CASCADA

        return redirect()->route('panel-de-staff')->with('alertEliminacion', [
            'type' => 'Success',
            'message' => 'La cuenta y la imagen fueron eliminadas con éxito',
        ]);
    }
}

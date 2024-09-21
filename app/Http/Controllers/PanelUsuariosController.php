<?php

namespace App\Http\Controllers;
#CLASES
use App\Models\Imagenes;
use App\Models\RevisionImagenes;
use App\Models\Roles;
use App\Models\StaffExtra;
use App\Models\TipodeStaff;
use App\Models\Usuario;

#Otros
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
        return $usuarios = $query->paginate(6);
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
            $usuario->urlImagen = $this->mirar($usuario->idusuarios);
        }

        // Retornar la vista con los usuarios, roles y el rol del usuario autenticado
        return view('profile.panelUsuarios', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'rol' => $rol,
            'especialidades' => $especialidades
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

    // Eliminar la imagen del usuario
    public function borrarImagen($id)
    {
        $existeFoto = RevisionImagenes::where('usuarios_idusuarios', $id)->where('tipoDeFoto_idtipoDeFoto', 1)->first();
        if ($existeFoto != null) {
            // Obtener el registro de la imagen anterior
            $imagen = Imagenes::find($existeFoto->imagenes_idimagenes);

            // Eliminar el registro de la revisión anterior
            $existeFoto->delete(); // IMPORTANTE: Eliminar primero la revisión

            // Eliminar el archivo del almacenamiento y el registro de la imagen anterior
            if ($imagen && Storage::exists($imagen->subidaImg)) {
                Storage::delete($imagen->subidaImg);
            }

            // Ahora eliminar el registro de la imagen anterior
            $imagen->delete();
            return redirect()->route('panel-de-usuarios')->with('alertEliminacion', [
                'type' => 'Success',
                'message' => 'Imagen eliminada exitosamente',
            ]);
        } else {
            return redirect()->route('panel-de-usuarios')->with('alertEliminacion', [
                'type' => 'Danger',
                'message' => 'No se puede eliminar la imagen por defecto del usuario',
            ]);
        }
    }

    // Eliminar el usuario en cascada
    public function eliminarUsuario($id)
    {
        // Encontrar al usuario
        $usuario = Usuario::find($id);

        // Eliminar el usuario en cascada
    }
}

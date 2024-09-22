<?php

namespace App\Http\Controllers;

# Clases necesarias
use App\Models\RedesSociales;
use App\Models\StaffExtra;
use App\Models\TipodeStaff;
use App\Models\Usuario;

# Clases de Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class redessocialesController extends Controller
{
    public $links; // Enlaces de redes sociales
    public $rol; // Rol del usuario
    public $idusuario; // ID del usuario
    public $nombreUsuario; // Nombre del usuario
    public $redSocialStaff; // Red social del staff
    public $concatenacion; // Concatenación del ID y nombre del usuario
    public $especialidad; // Especialidad del staff
    public $mostrarLink;

    public function __construct()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        $usuario = Usuario::where('usuarioUser', $usuario->usuarioUser)->first();

        // Asignar propiedades del usuario
        $this->rol = $usuario->rol_idrol;
        $this->idusuario = $usuario->idusuarios;
        $this->nombreUsuario = $usuario->usuarioUser;

        // Verificar rol y denegar acceso si es necesario
        if ($this->rol == 3 || $this->rol == 4) {
            abort(403, 'Acceso denegado');
        }

        // Si el rol es 2, obtener la especialidad del staff
        if ($this->rol == 2) {
            $staffextra = StaffExtra::where('usuarios_idusuarios', $this->idusuario)->first();
            $especialidad = TipodeStaff::where('idtipoStaff', $staffextra->tipoStaff_idtipoStaff)->first();
            $this->especialidad = $especialidad->nombreStaff;
        }

        // Concatenar ID de usuario y nombre para uso en redes sociales
        $this->concatenacion = $this->idusuario . $this->nombreUsuario;

        // Buscar la red social del staff
        $this->redSocialStaff = RedesSociales::where('nombreRedSocial', $this->concatenacion)->first();

        // Filtrar los enlaces de redes sociales según el rol del usuario
        $this->mostrarLink = $this->filtrarLinks();
    }

    // Filtrar los enlaces de redes sociales según el rol del usuario
    private function filtrarLinks()
    {
        if ($this->rol == 1) {
            // Si el rol es 1, mostrar redes que NO inicien con números
            return $this->links = RedesSociales::whereRaw("nombreRedSocial NOT REGEXP '^[0-9]'")->get();
        } elseif ($this->rol == 2) {
            // Si el rol es 2, mostrar solo la red social del staff (comienza con número)
            return $this->links = RedesSociales::where('nombreRedSocial', $this->concatenacion)->first();
        } else {
            // Si es rol 3 o 4, no debe visualizar nada
            return abort(403, 'Acceso denegado');
        }
    }
    // Mostrar la vista para modificar redes sociales
    public function modificarRedes()
    {
        return view('profile.modificarRedes', [
            'rol' => $this->rol,
            'links' => $this->links,
            'idusuario' => $this->idusuario,
            'nombreUsuario' => $this->nombreUsuario,
            'redSocialStaff' => $this->redSocialStaff,
            'especialidad' => $this->especialidad,
            'mostrarLink' => $this->mostrarLink,
        ]);
    }

    # Agregar una nueva red social
    public function agregarRed(Request $request)
    {
        // Verificar acceso
        if ($this->rol == 3 || $this->rol == 4) {
            abort(403, 'Acceso denegado');
        }

        // Validar entrada del usuario
        $request->validate([
            'linkRedSocial' => 'max:255|required',
            'nombreRedSocial' => 'max:255|required'
        ]);

        // Crear nueva entrada de red social
        $redSocial = new RedesSociales();
        $redSocial->linkRedSocial = $request->linkRedSocial;
        $redSocial->nombreRedSocial = ucwords($request->nombreRedSocial);
        $redSocial->save();

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('alertCambios', [
            'type' => 'Success',
            'message' => 'Se agregó una nueva red social.',
        ]);
    }

    # Separa que boton selecciono del formulario
    public function procesarRedes(Request $request)
    {
        // Verificar acceso
        if ($this->rol == 3 || $this->rol == 4) {
            abort(403, 'Acceso denegado');
        }

        $actionType = $request->input('action_type');

        if ($actionType == 'guardar') {
            // Lógica para guardar redes sociales
            $this->guardarRedes($request);
        } elseif ($actionType == 'eliminar') {
            // Lógica para eliminar red social
            $this->eliminarRedesBanda($request);
        }

        return redirect()->back();
    }

    # Guardar redes sociales de la BANDA seleccionadas
    public function guardarRedes(Request $request)
    {
        // Verificar acceso
        if ($this->rol == 3 || $this->rol == 4) {
            abort(403, 'Acceso denegado');
        }

        $linksRedSocial = $request->linkRedSocial ?? []; // Si es null, asigna un array vacío

        foreach ($linksRedSocial as $id => $nuevoLinkRedSocial) {
            $redSocial = RedesSociales::find($id);
            if ($redSocial) {
                $redSocial->linkRedSocial = $nuevoLinkRedSocial;
                $redSocial->save();
            }
        }

        return redirect()->back()->with('alertCambios', [
            'type' => 'Success',
            'message' => 'Las redes sociales han sido actualizadas correctamente.',
        ]);
    }

    // Método para eliminar redes sociales de la BANDA
    public function eliminarRedesBanda(Request $request)
    {
        // Verificar acceso
        if ($this->rol == 3 || $this->rol == 4) {
            abort(403, 'Acceso denegado');
        }

        $idRedSocial = $request->id;
        $redSocial = RedesSociales::find($idRedSocial);

        if ($redSocial) {
            $redSocial->delete();
            return redirect()->back()->with('alertCambios', [
                'type' => 'Success',
                'message' => 'La red social ha sido eliminada correctamente.',
            ]);
        } else {
            return redirect()->back()->with('alertCambios', [
                'type' => 'Error',
                'message' => 'No se pudo eliminar la red social.',
            ]);
        }
    }

    // Guardar red social del staff
    public function guardarRedesStaff(Request $request)
    {
        // Verificar acceso
        if ($this->rol == 3 || $this->rol == 4) {
            abort(403, 'Acceso denegado');
        }
        // Validar entrada
        $request->validate([
            'redSocialStaff' => 'required|max:255|url',
        ]);

        // Concatenar ID de usuario y nombre
        $concatenacion = $this->idusuario . $this->nombreUsuario;

        // Buscar la red social del staff
        $redSocial = RedesSociales::where('nombreRedSocial', $concatenacion)->first();

        // Si no existe, crear nueva entrada
        if (!$redSocial) {
            $redSocial = new RedesSociales();
            $redSocial->nombreRedSocial = $concatenacion;
        }

        // Guardar enlace de la red social
        $redSocial->linkRedSocial = $request->input('redSocialStaff');
        $redSocial->save();

        // Obtener el ID de la red social y actualizar el staff extra
        $idredsocial = $redSocial->idredesSociales;
        $staffExtra = StaffExtra::where('usuarios_idusuarios', $this->idusuario)->first();
        $staffExtra->redessociales_idredesSociales = $idredsocial;
        $staffExtra->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('modificar-redes')->with('alertCambios', [
            'type' => 'Success',
            'message' => 'El enlace de la red social del staff se ha actualizado correctamente.',
        ]);
    }

    // Eliminar la red social del staff
    public function eliminarRedSocialStaff(Request $request)
    {
        // Verificar acceso
        if ($this->rol == 3 || $this->rol == 4) {
            abort(403, 'Acceso denegado');
        }

        // Buscar la red social del staff
        $concatenacion = $this->idusuario . $this->nombreUsuario;
        $redSocial = RedesSociales::where('nombreRedSocial', $concatenacion)->first();

        if ($redSocial) {
            // Limpiar referencia de la red social en el staff extra
            $staffExtra = StaffExtra::where('usuarios_idusuarios', $this->idusuario)->first();
            $staffExtra->redessociales_idredesSociales = null;
            $staffExtra->save();

            // Eliminar la red social
            $redSocial->delete();

            // Redirigir con mensaje de éxito
            return redirect()->route('modificar-redes')->with('alertCambios', [
                'type' => 'Success',
                'message' => 'La red social del staff se ha eliminado correctamente.',
            ]);
        }

        // Si no se encontró la red social, redirigir con mensaje de error
        return redirect()->route('modificar-redes')->with('alertCambios', [
            'type' => 'Error',
            'message' => 'No se encontró la red social del staff.',
        ]);
    }
}

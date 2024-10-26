<?php

namespace App\Http\Controllers;

use App\Models\Notificaciones;
use App\Models\TipoNotificacion;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    // Visualiza las preferencias de notificaciones
    public function notificaciones()
    {
        $tipoNotificaciones = TipoNotificacion::all();

        // Recuperamos las preferencias del usuario
        $preferenciasUsuario = Notificaciones::where('usuarios_idusuarios', Auth::user()->idusuarios)
            ->pluck('tipoNotificación_idtipoNotificación')->toArray();

        return view('content.notificaciones', compact('tipoNotificaciones', 'preferenciasUsuario'));
    }

    // Guarda las preferencias de notificaciones
    public function guardarPreferencias(Request $request)
    {
        // Primero, eliminamos las notificaciones existentes para el usuario
        Notificaciones::where('usuarios_idusuarios', Auth::user()->idusuarios)->delete();

        // Guardamos las nuevas preferencias de notificaciones
        if ($request->has('activo')) {
            foreach ($request->activo as $tipoId) {
                // Verifica que el tipoId sea un valor válido antes de crear
                if (TipoNotificacion::find($tipoId)) { // Esto verifica si el tipo existe
                    Notificaciones::create([
                        'usuarios_idusuarios' => Auth::user()->idusuarios,
                        'tipoNotificación_idtipoNotificación' => $tipoId,
                    ]);
                }
            }
        }
        return redirect()->back()->with('alertRegistro', [
            'type' => 'Success',
            'message' => 'Preferencias guardadas con éxito.',
        ]);
    }

    // Cancelar todo tipo de notificacion
    public function cancelarTodo()
    {
        Notificaciones::where('usuarios_idusuarios', Auth::user()->idusuarios)->delete();
        return redirect()->back()->with('alertRegistro', [
            'type' => 'Success',
            'message' => 'Preferencias canceladas con éxito.',
        ]);
    }
}

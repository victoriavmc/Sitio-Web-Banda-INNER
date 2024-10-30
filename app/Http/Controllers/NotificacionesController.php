<?php

namespace App\Http\Controllers;

use App\Models\Notificaciones;
use App\Models\TipoNotificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\msjPreferenciaNotificaciones;
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

        // Array de notificaciones marcadas
        $notificacionesMarcadas = Notificaciones::where('usuarios_idusuarios', Auth::user()->idusuarios)
            ->pluck('tipoNotificación_idtipoNotificación')->toArray();

        if (empty($notificacionesMarcadas)) {
            Mail::to(Auth::user()->correoElectronicoUser)->send(new msjPreferenciaNotificaciones());
            return redirect()->back()->with('alerta', [
                'type' => 'Success',
                'message' => 'Preferencias canceladas con exito.',
            ]);
        }

        // Email de confirmación
        Mail::to(Auth::user()->correoElectronicoUser)->send(new msjPreferenciaNotificaciones($notificacionesMarcadas, 1));

        return redirect()->back()->with('alerta', [
            'type' => 'Success',
            'message' => 'Preferencias guardadas con éxito.',
        ]);
    }

    // Cancelar todo tipo de notificacion
    public function cancelarTodo()
    {
        if (empty(Notificaciones::where('usuarios_idusuarios', Auth::user()->idusuarios)->delete())) {
            return redirect()->back()->with('alerta', [
                'type' => 'Warning',
                'message' => 'No hay notificaciones para cancelar.',
            ]);
        }

        // Email de confirmación
        Mail::to(Auth::user()->correoElectronicoUser)->send(new msjPreferenciaNotificaciones());

        return redirect()->back()->with('alerta', [
            'type' => 'Success',
            'message' => 'Preferencias canceladas con éxito.',
        ]);
    }
}

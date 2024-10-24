<?php

namespace App\Http\Controllers;

use App\Models\TipoNotificacion;

use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    public function notificaciones()
    {

        $tipoNotificaciones = TipoNotificacion::all();
        return view('profile.notificaciones', compact('tipoNotificaciones'));
    }
}

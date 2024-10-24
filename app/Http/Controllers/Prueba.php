<?php

namespace App\Http\Controllers;

use App\Models\OrdenPago;
use App\Models\Precio;

class Prueba extends Controller
{
    // Mostrar index
    public function listarComprobantes()
    {
        // Cargar relaciones precio y usuario para evitar consultas adicionales
        $comprobantes = OrdenPago::with(['precio', 'usuario'])->get();

        return view('api.ordendepago', compact('comprobantes'));
    }
}

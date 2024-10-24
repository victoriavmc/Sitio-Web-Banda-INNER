<?php

namespace App\Http\Controllers;

use App\Models\OrdenPago;
use Illuminate\Http\Request;

class Prueba extends Controller
{
    // Mostrar index
    public function listarComprobantes()
    {
        $comprobantes = OrdenPago::all();
        return view('api.ordendepago', compact('comprobantes'));
    }
}

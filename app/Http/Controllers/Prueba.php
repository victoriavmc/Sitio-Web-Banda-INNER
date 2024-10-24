<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Prueba extends Controller
{
    // Mostrar index
    public function listarComprobantes()
    {
        return view('api.ordendepago');
    }
}

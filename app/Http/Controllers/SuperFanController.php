<?php

namespace App\Http\Controllers;

use App\Models\Precio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SuperFanController extends Controller
{
    public function indexSuperFan()
    {
        if (Auth::check() && (Auth::user()->rol->idrol == 1 || Auth::user()->rol->idrol == 2)) {
            return redirect()->route('underConstruction');
        }

        return view('content.superFan');
    }

    public function precioAgregar() {}

    public function precioModificar() {}

    public function precioMostrarTodosLosCargados() {}

    public function precioMostrar()
    {
        // Traigo el precio de la base de datos
        $ultimoPrecio = Precio::orderBy('idprecio', 'desc')->first();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperFanController extends Controller
{
    public function indexSuperFan()
    {
        return view('content.superFan');
    }

    # Selecciona cual visualiza si es un tercero o alguien registrado
}
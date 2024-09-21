<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class inicioController extends Controller
{
    public function __invoke()
    {
        return view('inicio');
    }
}

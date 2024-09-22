<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class inicioController extends Controller
{
    public function index()
    {
        $shows = Show::orderBy('fechashow', 'desc')->get();

        return view('inicio', compact('shows'));
    }
}

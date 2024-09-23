<?php

namespace App\Http\Controllers;

use App\Models\Imagenes;
use App\Models\LugarLocal;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use Illuminate\Http\Request;

class eventosController extends Controller
{
    public function eventos()
    {
        $shows = Show::orderBy('fechashow', 'desc')->get();

        return view('events.eventos', compact('shows'));
    }

    public function evento($id)
    {
        $show = Show::find($id);

        return view('events.evento', compact('show'));
    }
}

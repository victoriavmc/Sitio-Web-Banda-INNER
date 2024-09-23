<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class eventosController extends Controller
{
    public function eventos()
    {
        $shows = Show::orderBy('fechashow', 'desc')->get();

        return view('events.eventos', compact('shows'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class eventosController extends Controller
{
    public function eventos()
    {
        return view('events.eventos');
    }
}

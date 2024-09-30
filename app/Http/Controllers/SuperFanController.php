<?php

namespace App\Http\Controllers;

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
}

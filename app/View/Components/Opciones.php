<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Opciones extends Component
{

    public $rol;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $usuario = Auth::user();
        $this->rol = $usuario->rol_idrol;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.Opciones');
    }
}

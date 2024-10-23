<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class galeriaInterna extends Component
{
    public $titulo;
    public $fecha;
    public $medios;
    public $tipo;
    /**
     * Create a new component instance.
     */
    public function __construct($titulo, $fecha, $medios, $tipo)
    {
        $this->titulo = $titulo;
        $this->fecha = $fecha;
        $this->medios = $medios;
        $this->tipo = $tipo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.galeria-interna');
    }
}

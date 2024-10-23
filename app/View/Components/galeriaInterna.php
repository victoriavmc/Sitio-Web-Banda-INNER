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
    /**
     * Create a new component instance.
     */
    public function __construct($titulo, $fecha, $medios)
    {
        $this->titulo = $titulo;
        $this->fecha = $fecha;
        $this->medios = $medios;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.galeria-interna');
    }
}

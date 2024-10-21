<?php

namespace App\View\Components;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class ManejoAlbum extends Component
{
    public $accion;
    public $tipoAlbum;
    public $titulo;

    public function __construct($accion, $tipoAlbum, $titulo)
    {
        $this->accion = $accion;
        $this->tipoAlbum = $tipoAlbum;
        $this->titulo = $titulo;
    }

    /**
     * Método render requerido por los componentes de Blade.
     * Si no necesitas mostrar una vista específica, puedes devolver null.
     */
    public function render(): View|Closure|string
    {
        $titulo = match ($this->tipoAlbum) {
            1 => 'Música',
            2 => 'Videos',
            3 => 'Imágenes',
        };

        return view('manejo-album', [
            'accion' => $this->accion,
            'tipoAlbum' => $this->tipoAlbum,
            'titulo' => $titulo,
        ]);
    }
}

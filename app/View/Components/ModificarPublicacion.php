<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModificarPublicacion extends Component
{
    public $action;
    public $contenido;
    public $imagenes; // Añadir esta línea para recibir las imágenes

    public function __construct($action, $contenido, $imagenes) // Asegúrate de recibir las imágenes
    {
        $this->action = $action;
        $this->contenido = $contenido;
        $this->imagenes = $imagenes; // Asigna las imágenes a la propiedad
    }

    public function render()
    {
        return view('components.Modificar-publicacion', [
            'action' => $this->action,
            'contenido' => $this->contenido,
            'imagenes' => $this->imagenes, // Pasa las imágenes a la vista del componente
        ]);
    }
}

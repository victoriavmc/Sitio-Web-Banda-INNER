<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormularioCreate extends Component
{
    public $formType; // Para definir el tipo de formulario

    public function __construct($formType)
    {
        $this->formType = $formType;
    }

    public function render()
    {
        return view('components.formulario-create');
    }
}

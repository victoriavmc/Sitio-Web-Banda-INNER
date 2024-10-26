<?php

namespace App\View\Components;

use App\Models\Precios;
use App\Models\PrecioServicios;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class LadoDerecho extends Component
{
    public $usuario;
    public $ultimoPrecio;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->usuario = Auth::user();

        // Último precio de suscripción
        $ultimoPrecio = PrecioServicios::where('tipoServicio', 'Suscripción')
            ->first();

        return $ultimoPrecio;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lado-derecho');
    }
}

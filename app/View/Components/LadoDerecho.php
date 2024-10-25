<?php

namespace App\View\Components;

use App\Models\Precio;
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
        $ultimoPrecio = Precio::where('tipoServicio', 'Suscripción')
            ->where('estadoPrecio', 'Activo')
            ->orderBy('fechaPrecio', 'desc')
            ->first();

        return $this->ultimoPrecio = $ultimoPrecio->precio;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lado-derecho');
    }
}

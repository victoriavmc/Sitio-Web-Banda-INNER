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
        // Buscar precios de servicios de tipo "Suscripción" con referenciaIdFicticio igual a 0
        $preciosServicios = PrecioServicios::where('referenciaIdFicticio', 0)
            ->where('tipoServicio', 'Suscripción')
            ->get();

        // Recorrer los precios encontrados
        foreach ($preciosServicios as $servicio) {
            // Buscar el primer precio activo usando la relación
            $ultimoPrecio = $servicio->precios()->where('estadoPrecio', 'Activo')->first();

            // Si existe un precio activo, asignarlo a la propiedad
            if ($ultimoPrecio) {
                $this->ultimoPrecio = $ultimoPrecio->precio; // Asignamos el valor a la propiedad
                return; // Salimos del constructor
            }
        }

        // Si no se encuentra ningún precio activo, asignar null
        $this->ultimoPrecio = null;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lado-derecho');
    }
}

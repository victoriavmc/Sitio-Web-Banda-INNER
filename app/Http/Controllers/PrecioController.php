<?php

namespace App\Http\Controllers;

use App\Models\Precios;
use App\Models\PrecioServicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrecioController extends Controller

{
    // Validar
    public function rules()
    {
        return [
            'precio' => 'required|numeric|min:0',
        ];
    }

    // Crear nuevo precio
    public function create(Request $request)
    {
        $precio = new Precios();
        $precio->precio = $request->precio;
        $precio->save();

        return $precio;
    }

    // Desactivar precio existente
    public function cambioPrecioSuscripcion($idPrecio)
    {
        $precio = Precios::find($idPrecio);
        if ($precio) {
            $precio->estadoPrecio = 'Inactivo';
            $precio->save();
        }
    }

    // Revisar si el precio está asociado a algún servicio
    public function revisoPrecioSuscripcion($idPrecio)
    {
        return PrecioServicios::where('precios_idprecios', $idPrecio)->count();
    }


    // Crear relación de precio con el servicio
    public function createPrecioServicio($idPrecio, $tipoServicio, $idReferencial)
    {
        $precioServicio = new PrecioServicios();
        $precioServicio->precios_idprecios = $idPrecio;
        $precioServicio->tipoServicio = $tipoServicio;
        $precioServicio->referenciaIdFicticio = $idReferencial;
        $precioServicio->save();
    }

    // Obtener el último precio activo de suscripción
    public function mostrarPrecio()
    {
        $precioServicio = PrecioServicios::where('referenciaIdFicticio', 0)
            ->where('tipoServicio', 'Suscripción')
            ->orderBy('idprecioServicio', 'desc')
            ->first();

        if ($precioServicio) {
            $precio = Precios::find($precioServicio->precios_idprecios);
            return $precio;
        }

        return null;
    }

    public function eliminarPrecioSubscripcion()
    {
        $precio = $this->mostrarPrecio();

        $precio->estadoPrecio = 'Inactivo';

        $precio->save();

        return redirect()->back()->with('alertPrecio', [
            'type' => 'Success',
            'message' => 'Precio Eliminado correctamente!.',
        ]);
    }

    // Cambiar precio de suscripción
    public function cambiaPrecioSuscripcion(Request $request)
    {
        // Realizar la validación manualmente
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertPrecio', [
                'type' => 'Warning',
                'message' => 'Error al cargar datos.',
            ]);
        }

        $precio = $this->mostrarPrecio();

        if ($precio) {
            $precio->estadoPrecio = 'Inactivo';
            $precio->save();
        }


        // Crear un nuevo precio y asociarlo
        $nuevoPrecio = $this->create($request);
        $this->createPrecioServicio($nuevoPrecio->idprecios, 'Suscripción', 0);

        return redirect()->back()->with('alertPrecio', [
            'type' => 'Success',
            'message' => 'Precio Actualizado correctamente!.',
        ]);
    }
}

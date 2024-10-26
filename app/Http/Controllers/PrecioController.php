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
            'idFicticio' => 'required|integer',
            'tipoServicio' => 'required|string|in:Suscripción,Show',
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
            ->first();

        if ($precioServicio) {
            $ultimoPrecio = $precioServicio->precios->where('estadoPrecio', 'Activo')->first();
            return $ultimoPrecio ? $ultimoPrecio->precio : null;
        }

        return null;
    }

    // Cambiar precio de suscripción
    public function cambiaPrecioSuscripcion(Request $request)
    {
        // Realizar la validación manualmente
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertRegistro', [
                'type' => 'Warning',
                'message' => 'Error al cargar datos.',
            ]);
        }

        // Precio nuevo desde la solicitud
        $precioNuevo = $request->input('precio');
        $ultimoPrecio = $this->mostrarPrecio();
        $idFicticio = $request->input('idFicticio');

        if (!$ultimoPrecio) {
            // Crear un nuevo precio y asociarlo
            $nuevoPrecio = $this->create($request);
            $this->createPrecioServicio($nuevoPrecio->idprecios, 'Suscripción', $idFicticio);
        } else {
            $precioViejo = Precios::where('precio', $ultimoPrecio)->first();

            if ($precioViejo) {
                $idPrecio = $precioViejo->idprecios;

                // Revisar si el precio está en uso por más de un servicio
                if ($this->revisoPrecioSuscripcion($idPrecio) == 1) {
                    // Desactivar el precio porque NO se comparte en más de un servicio
                    $this->cambioPrecioSuscripcion($idPrecio);
                }
                // Revisar si el nuevo precio ya existe
                $precioNuevoExiste = Precios::where('precio', $precioNuevo)->first();

                if ($precioNuevoExiste) {
                    $precioNuevoExiste->estadoPrecio = 'Activo';
                    $precioNuevoExiste->save();

                    // Actualizar la relación de precio servicio
                    $precioServicio = PrecioServicios::where('precios_idprecios', $idPrecio)->first();
                    $precioServicio->precios_idprecios = $precioNuevoExiste->idprecios;
                    $precioServicio->save();
                } else {
                    // Crear el nuevo precio si no existe
                    $nuevoPrecio = $this->create($request);
                    $idPrecio = $precioViejo->idprecios;
                    $precioServicio = PrecioServicios::where('precios_idprecios', $idPrecio)->first();

                    $precioServicio->precios_idprecios = $nuevoPrecio->idprecios;
                    $precioServicio->save();
                }
            }
        }
        return redirect()->back()->with('alertRegistro', [
            'type' => 'Success',
            'message' => 'Precio Actualizado correctamente!.',
        ]);
    }
}

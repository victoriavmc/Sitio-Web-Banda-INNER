<?php

namespace App\Http\Controllers;

use App\Models\Precios;
use App\Models\PrecioServicios;
use Illuminate\Http\Request;

class PrecioController extends Controller

{
    // // Validar
    // public function rules()
    // {
    //     return [
    //         'precio' => 'required|numeric|min:0',
    //         'idFicticio' => 'required|integer',
    //         'tipoServicio' => 'required|string|in:Suscripción,Show',
    //     ];
    // }

    // // Logica de crear precio
    // public function logicaCrearPrecio($precio, $idFicticio, $tipoServicio)
    // {
    //     //Creo un Precio
    //     $precioNuevo = new Precios();
    //     $precioNuevo->precio = $precio;
    //     $precioNuevo->save();

    //     $precioNuevo2 = new PrecioServicios();
    //     $precioNuevo2->referenciaIdFicticio = $idFicticio;
    //     $precioNuevo2->tipoServicio = $tipoServicio;
    //     $precioNuevo2->precioId = $precioNuevo->idprecios;
    //     $precioNuevo2->save();

    //     return $precioNuevo, $precioNuevo2;
    // }

    // // Agregar/Modificar Precio
    // public function agregarPrecio(Request $request)
    // {
    //     $this->rules($request);

    //     $precio = $request->input('precio');
    //     $idFicticio = $request->input('idFicticio');
    //     $tipoServicio = $request->input('tipoServicio');

    //     // ID del precio actual, si existe
    //     $precioActual = $request->input('idPrecio');

    //     // Inactivar el precio actual si existe y es de tipo 'Suscripcion'
    //     if ($tipoServicio === 'Suscripción') {
    //         // Buscar si el nuevo precio ya existe en la base de datos
    //         $precioExistente = Precios::where('precio', $precio)
    //             ->where('tipoServicio', $tipoServicio)
    //             ->first();

    //         // Si el precio ya existe y está inactivo, activarlo
    //         if ($precioExistente) {
    //             $precioExistente->estadoPrecio = 'Activo';
    //             $precioExistente->save();
    //             return response()->json(['message' => 'Precio existente activado con éxito']);
    //         }

    //         // Inactivar el precio actual si existe
    //         if ($precioActual) {
    //             $precioAnterior = Precio::find($precioActual);
    //             if ($precioAnterior) {
    //                 $precioAnterior->estadoPrecio = 'Inactivo';
    //                 $precioAnterior->save();
    //             }
    //         }
    //     } elseif ($tipoServicio === 'Show') {
    //         // Verificar si el precio ya existe para el idFicticio específico
    //         $precioExistente = Precio::where('precio', $precio)
    //             ->where('tipoServicio', $tipoServicio)
    //             ->where('referenciaIdFicticio', $idFicticio) // Asegúrate de que coincida con el idFicticio
    //             ->first();

    //         // Si el precio ya existe y está inactivo, activarlo
    //         if ($precioExistente && $precioExistente->estadoPrecio === 'Inactivo') {
    //             $precioExistente->estadoPrecio = 'Activo';
    //             $precioExistente->referenciaIdFicticio = $idFicticio; // Asigna el idFicticio
    //             $precioExistente->save();
    //             return response()->json(['message' => 'Precio existente activado con éxito']);
    //         }

    //         // Si el precio ya está en uso por otro show, no lo inactivamos.
    //         // Verificamos si hay otro show que esté usando este precio
    //         $precioUsadoPorOtroShow = Precio::where('precio', $precio)
    //             ->where('tipoServicio', $tipoServicio)
    //             ->where('estadoPrecio', 'Activo')
    //             ->where('referenciaIdFicticio', '!=', $idFicticio) // Asegúrate de que no sea el mismo show
    //             ->exists();

    //         if (!$precioUsadoPorOtroShow) {
    //             // Inactivar el precio actual si existe
    //             if ($precioActual) {
    //                 $precioAnterior = Precio::find($precioActual);
    //                 if ($precioAnterior) {
    //                     $precioAnterior->estadoPrecio = 'Inactivo';
    //                     $precioAnterior->save();
    //                 }
    //             }
    //         }
    //     } else {
    //         // Si no existe el precio, crear un nuevo precio
    //         $this->logicaCrearPrecio($precio, $idFicticio, $tipoServicio);

    //         return response()->json(['message' => 'Precio agregado con éxito']);
    //     }
    // }

    // Ver el último precio según el tipo de servicio
    // public function verUltimoPrecio(Request $request)
    // {
    //     $idFicticio = $request->input('idFicticio');

    //     // if ($request->input('tipoServicio') === 'Suscripción') {
    //     //     // Último precio de suscripción
    //     //     $ultimoPrecio = Precios::where('tipoServicio', 'Suscripción')
    //     //         ->where('estadoPrecio', 'Activo')
    //     //         ->first();
    //     // } else {
    //     //     // Último precio para un show específico
    //     //     $ultimoPrecio = Precios::where('tipoServicio', 'Show')
    //     //         ->where('referenciaIdFicticio', $idFicticio)
    //     //         ->where('estadoPrecio', 'Activo')
    //     //         ->orderBy('fechaPrecio', 'desc')
    //     //         ->first();
    //     // }

    //     return response()->json($ultimoPrecio);
    // }


}

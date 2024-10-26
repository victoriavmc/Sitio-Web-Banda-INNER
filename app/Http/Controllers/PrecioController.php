<?php

namespace App\Http\Controllers;

use App\Models\Precios;
use App\Models\PrecioServicios;
use Illuminate\Http\Request;

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

    // Logica de crear precio



}

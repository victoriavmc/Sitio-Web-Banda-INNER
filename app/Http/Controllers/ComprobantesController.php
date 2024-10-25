<?php

namespace App\Http\Controllers;

use App\Exports\ComprobantesExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\OrdenPago;
use App\Models\Precio;

class ComprobantesController extends Controller
{
    // Mostrar index
    public function listarComprobantes()
    {
        // Cargar relaciones precio y usuario para evitar consultas adicionales
        $comprobantes = OrdenPago::with(['precio', 'usuario'])->paginate(10);

        return view('api.ordendepago', compact('comprobantes'));
    }

    public function descargarExcel()
    {
        return Excel::download(new ComprobantesExport, 'comprobantes.xlsx');
    }
}

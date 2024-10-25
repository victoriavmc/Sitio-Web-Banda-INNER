<?php

namespace App\Http\Controllers;

use App\Exports\ComprobantesExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\OrdenPago;
use App\Models\Precio;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

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

    // En caso de que sea de un usuario
    public function listarComprobantesUsuarioEspecifico()
    {
        $idusuario = Auth::user()->idusuarios;

        $comprobantes = OrdenPago::where('idusuario', $idusuario)->with(['precio', 'usuario'])->paginate(10);

        return view('api.usuarioordendepago', compact('comprobantes'));
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateShowStatus extends Command
{
    protected $signature = 'shows:update-status';
    protected $description = 'Actualizar el estado de los shows a Inactivo si la fecha ha pasado y borrar linkCompraEntrada';

    public function handle()
    {
        // Actualizar el estado y borrar linkCompraEntrada
        DB::table('show')
            ->where('fechashow', '<', now())
            ->update(['estadoShow' => 'Inactivo', 'linkCompraEntrada' => null]);
    }
}

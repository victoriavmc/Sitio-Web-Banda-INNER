<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateShowStatus extends Command
{
    protected $signature = 'shows:update-status';
    protected $description = 'Actualizar el estado de los shows a Inactivo si la fecha ha pasado';

    public function handle()
    {
        // Actualizar el estado
        DB::table('show')
            ->where('fechashow', '<', now())
            ->update(['estadoShow' => 'Inactivo']);

        DB::table('historialusuario')
            ->where('fechaFinaliza', '<', now())
            ->update(['estado' => 'Inactivo']);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    protected $table = 'reportes';
    public $timestamps = false;
    protected $primaryKey = 'idreportes';

    // Asignar valores por defecto si no están establecidos
    protected static function booted()
    {
        static::creating(function ($reportes) {
            $reportes->reportes = $reportes->reportes ?? 0;
        });
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }
}

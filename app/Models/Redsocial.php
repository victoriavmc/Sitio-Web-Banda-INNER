<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redsocial extends Model
{
    protected $table = 'redsocial';
    public $timestamps = false;
    protected $primaryKey = 'idredsocial';

    // Asignar valores por defecto si no están establecidos
    protected static function booted()
    {
        static::creating(function ($redsocial) {
            $redsocial->reportes = $redsocial->reportes ?? 0;
        });
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }
}

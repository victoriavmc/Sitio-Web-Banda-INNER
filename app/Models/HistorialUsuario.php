<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialUsuario extends Model
{
    protected $table = "historialusuario";
    protected $primaryKey = 'idhistorialusuario';
    public $timestamps = false;

    public function datospersonales()
    {
        return $this->belongsTo(DatosPersonales::class, 'datospersonales_idDatosPersonales', 'idDatosPersonales');
    }

    # Se ejecuta justo antes de que se cree un nuevo registro en la base de datos
    protected static function booted()
    {
        static::creating(function ($historialUsuario) {
            $historialUsuario->estado = $historialUsuario->estado ?? 'Activo';
            $historialUsuario->eliminacionLogica = $historialUsuario->eliminacionLogica ?? 'No';
            $historialUsuario->fechaInicia = $historialUsuario->fechaInicia ?? now();
        });
    }
}

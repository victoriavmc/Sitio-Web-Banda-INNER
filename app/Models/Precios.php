<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Precios extends Model
{
    // Definimos la tabla correspondiente
    protected $table = 'precios';

    // Definimos la clave primaria
    protected $primaryKey = 'idprecios';

    // Habilitamos el autoincremento
    public $incrementing = true;

    // Desactivamos el timestamp por defecto de Laravel
    public $timestamps = false;

    // Evento para establecer el estado por defecto
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($precios) {
            $precios->estadoPrecio = 'Activo';
        });
    }

    // En el modelo Precios
    public function precioServicio()
    {
        return $this->belongsTo(PrecioServicios::class, 'precios_idprecios', 'idprecioServicio');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    // Definimos la tabla correspondiente
    protected $table = 'precio';

    // Definimos la clave primaria
    protected $primaryKey = 'idprecio';

    // Habilitamos el autoincremento
    public $incrementing = true;

    // Desactivamos el timestamp por defecto de Laravel
    public $timestamps = false;

    // Evento para establecer el estado por defecto
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($precio) {
            $precio->estadoPrecio = 'Activo';
            $precio->fechaPrecio = now();
        });
    }

    // Relación inversa con el modelo OrdenPago
    public function ordenesPago()
    {
        return $this->hasMany(OrdenPago::class, 'precio_idprecio', 'idprecio');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecioServicios extends Model
{
    // Definimos la tabla correspondiente
    protected $table = 'precioServicio';

    // Definimos la clave primaria
    protected $primaryKey = 'idprecioServicio';

    // Habilitamos el autoincremento
    public $incrementing = true;

    // Desactivamos el timestamp por defecto de Laravel
    public $timestamps = false;

    // En el modelo PrecioServicios
    public function precios()
    {
        return $this->hasMany(Precios::class, 'idprecios', 'precios_idprecios');
    }


    // Relación con `OrdenPago` (un `precioServicio` puede tener muchas `ordenesPago`)
    public function ordenesPago()
    {
        return $this->hasMany(OrdenPago::class, 'precioServicio_idprecioServicio', 'idprecioServicio');
    }
}

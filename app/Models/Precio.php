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
}

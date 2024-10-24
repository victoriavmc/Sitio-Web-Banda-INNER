<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    // Definimos la tabla correspondiente
    protected $table = 'notificaciones';

    // Definimos la clave primaria
    protected $primaryKey = 'idnotificaciones';

    // Habilitamos el autoincremento
    public $incrementing = true;

    // Desactivamos el timestamp por defecto de Laravel
    public $timestamps = false;
}

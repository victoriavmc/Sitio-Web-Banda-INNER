<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenPago extends Model
{
    // Definimos la tabla correspondiente
    protected $table = 'ordenpago';

    // Definimos la clave primaria
    protected $primaryKey = 'idordenpago';

    // Habilitamos el autoincremento
    public $incrementing = true;

    // Desactivamos el timestamp por defecto de Laravel
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function precioServicio()
    {
        return $this->belongsTo(PrecioServicios::class, 'precioServicio_idprecioServicio', 'idprecioServicio');
    }
}

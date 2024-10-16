<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    // Definimos la tabla correspondiente
    protected $table = 'suscripcion';

    // Definimos la clave primaria
    protected $primaryKey = 'idsuscripcion';

    // Habilitamos el autoincremento
    public $incrementing = true;

    // Desactivamos el timestamp por defecto de Laravel
    public $timestamps = false;

    // Definimos los campos que se pueden asignar masivamente
    protected $fillable = [
        'preference_id',
        'amount',
        'payment_method',
        'created_at',
        'usuarios_idusuarios',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }
}

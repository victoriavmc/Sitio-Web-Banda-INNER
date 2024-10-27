<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNotificacion extends Model
{
    // Definimos la tabla correspondiente
    protected $table = 'tiponotificación';

    // Definimos la clave primaria
    protected $primaryKey = 'idtipoNotificación';

    // Habilitamos el autoincremento
    public $incrementing = true;

    // Desactivamos el timestamp por defecto de Laravel
    public $timestamps = false;
    // Definimos la relación inversa con Notificaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificaciones::class, 'tipoNotificación_idtipoNotificación', 'idtipoNotificación');
    }
}

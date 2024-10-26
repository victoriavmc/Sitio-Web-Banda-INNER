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

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuarios_idusuarios',
        'tipoNotificación_idtipoNotificación'
    ];

    // Definimos la relación con el modelo TipoNotificacion
    public function tipoNotificacion()
    {

        return $this->belongsTo(TipoNotificacion::class, 'tipoNotificación_idtipoNotificación', 'idtipoNotificación');
    }
}

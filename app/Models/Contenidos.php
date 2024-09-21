<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenidos extends Model
{
    protected $table = 'contenidos';
    protected $primaryKey = 'idcontenidos';
    public $timestamps = false;

    // Relación con TipoContenido
    public function tipoContenido()
    {
        return $this->belongsTo(TipoContenido::class, 'tipoContenido_idtipoContenido', 'idtipoContenido');
    }

    // Relación con Usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }

    // Relación con Actividad
    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'Actividad_idActividad', 'idActividad');
    }

    // Relación con ImagenesContenido
    public function imagenesContenido()
    {
        return $this->hasMany(ImagenesContenido::class, 'contenidos_idcontenidos', 'idcontenidos');
    }

    // Relación con Comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'contenidos_idcontenidos', 'idcontenidos');
    }
}

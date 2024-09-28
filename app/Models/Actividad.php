<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividad';
    protected $primaryKey = 'idActividad';
    public $timestamps = false;

    // Relación con Usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }

    // Relación con Contenidos
    public function contenidos()
    {
        return $this->hasMany(Contenidos::class, 'Actividad_idActividad', 'idActividad');
    }

    // Relación con Comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'Actividad_idActividad', 'idActividad');
    }
}

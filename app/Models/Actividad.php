<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Actividad extends Model
{
    protected $table = 'actividad';
    protected $primaryKey = 'idActividad';
    public $timestamps = false;

    protected $fillable = [
        'tipoActividad_idtipoActividad',
        'usuarios_idusuarios',
    ];

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

    public function interacciones()
    {
        return $this->hasMany(interacciones::class);
    }
}

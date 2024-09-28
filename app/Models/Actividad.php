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

    # Se ejecuta justo antes de que se cree un nuevo registro de contenidos o comentarios en la base de datos
    protected static function booted()
    {
        // Este evento se ejecuta justo antes de que se cree un nuevo registro
        static::creating(function ($actividad) {
            // Asignar valores por defecto si no se han establecido ESTO ELIMINAR DESPUES
            $actividad->contadorMg = $actividad->contadorMg ?? 0;
            $actividad->contadorNM = $actividad->contadorNM ?? 0;
            $actividad->reporte = $actividad->reporte ?? 0;

            if (Auth::check()) {
                $actividad->usuarios_idusuarios = Auth::user()->idusuarios;
            }
        });
    }

    public function interacciones()
    {
        return $this->hasMany(interacciones::class);
    }
}

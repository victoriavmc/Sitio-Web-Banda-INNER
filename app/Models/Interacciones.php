<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interacciones extends Model
{
    use HasFactory;

    // Relación con Usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }
}

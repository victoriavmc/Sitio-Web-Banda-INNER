<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interacciones extends Model
{
    protected $table = 'interacciones';
    protected $primaryKey = 'idinteracciones';
    public $timestamps = false;

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

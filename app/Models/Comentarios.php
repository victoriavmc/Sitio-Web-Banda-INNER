<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    protected $table = 'comentarios';
    protected $primaryKey = 'idcomentarios';
    public $timestamps = false;

    // Relación con Actividad
    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'Actividad_idActividad', 'idActividad');
    }

    // Relación con Contenidos
    public function contenidos()
    {
        return $this->belongsTo(Contenidos::class, 'contenidos_idcontenidos', 'idcontenidos');
    }

    // Relación con RevisionImagenes
    public function revisionImagenes()
    {
        return $this->belongsTo(RevisionImagenes::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }
}

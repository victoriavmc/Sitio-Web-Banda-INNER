<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenesContenido extends Model
{
    protected $table = 'imagenescontenido';
    protected $primaryKey = 'idimagenescontenido';
    public $timestamps = false;

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

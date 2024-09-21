<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContenido extends Model
{
    protected $table = 'tipocontenido';
    protected $primaryKey = 'idtipoContenido';
    public $timestamps = false;

    // Relación con Contenidos
    public function contenidos()
    {
        return $this->hasMany(Contenidos::class, 'tipoContenido_idtipoContenido', 'idtipoContenido');
    }
}

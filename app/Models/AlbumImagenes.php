<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumImagenes extends Model
{
    protected $table = 'albumimagenes';
    protected $primaryKey = 'albumImagenescol';
    public $timestamps = false;

    public function albumDatos()
    {
        return $this->belongsTo(AlbumDatos::class, 'albumDatos_idalbumDatos', 'idalbumDatos');
    }

    public function revisionImagenes()
    {
        return $this->belongsTo(RevisionImagenes::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }
}

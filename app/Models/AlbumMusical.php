<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumMusical extends Model
{
    protected $table = 'albummusical';
    protected $primaryKey = 'albumMusicalcol';
    public $timestamps = false;

    public function albumDatos()
    {
        return $this->belongsTo(AlbumDatos::class, 'albumDatos_idalbumDatos', 'idalbumDatos');
    }

    public function revisionImagenes()
    {
        return $this->belongsTo(RevisionImagenes::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    public function canciones()
    {
        return $this->hasMany(Cancion::class, 'albumMusical_albumMusicalcol', 'albumMusicalcol');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionImagenes extends Model
{
    use HasFactory;

    protected $table = "revisionimagenes";
    public $primaryKey = "idrevisionImagenescol";

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function imagenes()
    {
        return $this->belongsTo(Imagenes::class, 'imagenes_idimagenes', 'idimagenes');
    }

    public function tipodefoto()
    {
        return $this->belongsTo(TipoDeFoto::class, 'tipodefoto_idtipodefoto', 'idtipodefoto');
    }

    public function artistas()
    {
        return $this->hasMany(Artistas::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    public function albumMusical()
    {
        return $this->hasMany(AlbumMusical::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    public function shows()
    {
        return $this->hasMany(Show::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    public function albumImagenes()
    {
        return $this->hasMany(AlbumImagenes::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    public function imagenesContenido()
    {
        return $this->hasMany(ImagenesContenido::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }
}

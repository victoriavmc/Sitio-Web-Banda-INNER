<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeFoto extends Model
{
    protected $table = "tipodefoto";
    protected $primaryKey = "idtipoDeFoto";
    public $timestamps = false;

    public function revisionImagenes()
    {
        return $this->hasMany(RevisionImagenes::class, 'tipodefoto_idtipodefoto', 'idtipodefoto');
    }
}

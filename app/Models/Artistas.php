<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artistas extends Model
{
    protected $table = "artistas";
    public $timestamps = false;
    protected $primaryKey = 'idartistas';

    // Relación con RevisionImagenes (cada artista tiene una clave foránea de revisionImagenes)
    public function revisionImagenes()
    {
        return $this->belongsTo(RevisionImagenes::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    // Relación con StaffExtra (cada artista tiene una clave foránea de staffExtra)
    public function staffExtra()
    {
        return $this->belongsTo(StaffExtra::class, 'staffextra_idstaffExtra', 'idstaffExtra');
    }
}

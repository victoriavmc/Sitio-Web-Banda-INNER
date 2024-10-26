<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $table = 'show';  // Nombre de la tabla
    protected $primaryKey = 'idshow';  // Clave primaria
    public $timestamps = false;  // Sin columnas created_at y updated_at

    protected $fillable = [
        'fechashow',
        'estadoShow',
        'ubicacionShow_idubicacionShow',
        'lugarLocal_idlugarLocal',
    ];

    // Relación con UbicacionShow
    public function ubicacionShow()
    {
        return $this->belongsTo(UbicacionShow::class, 'ubicacionShow_idubicacionShow', 'idubicacionShow');
    }

    // Relación con RevisionImagenes
    public function revisionImagenes()
    {
        return $this->belongsTo(RevisionImagenes::class, 'revisionImagenes_idrevisionImagenescol', 'idrevisionImagenescol');
    }

    // Relación con LugarLocal
    public function lugarLocal()
    {
        return $this->belongsTo(LugarLocal::class, 'lugarLocal_idlugarLocal', 'idlugarLocal');
    }
}

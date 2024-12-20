<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    protected $table = 'reportes';
    public $timestamps = false;
    protected $primaryKey = 'idreportes';

    protected $fillable = [
        'usuarios_idusuarios',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function motivos()
    {
        return $this->belongsTo(Motivos::class, 'motivos_idmotivos', 'idmotivos');
    }
}

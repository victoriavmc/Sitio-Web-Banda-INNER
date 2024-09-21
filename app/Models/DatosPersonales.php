<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paisnacimiento;
use App\Models\Usuario;

class DatosPersonales extends Model
{
    protected $table = "datospersonales";
    public $timestamps = false;
    protected $primaryKey = 'idDatosPersonales';

    protected $fillable = [
        'nombreDP',
        'apellidoDP',
        'fechaNacimiento',
        'PaisNacimiento_idPaisNacimiento',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function paisnacimiento()
    {
        return $this->belongsTo(Paisnacimiento::class, 'PaisNacimiento_idPaisNacimiento', 'idPaisNacimiento');
    }

    public function historialusuario()
    {
        return $this->hasMany(HistorialUsuario::class, 'datospersonales_idDatosPersonales', 'idDatosPersonales');
    }
}

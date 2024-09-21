<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paisnacimiento extends Model
{
    use HasFactory;

    protected $table = "paisnacimiento";
    protected $primaryKey = 'idPaisNacimiento';
    public $timestamps = false;

    public function datospersonales()
    {
        return $this->hasOne(DatosPersonales::class, 'PaisNacimiento_idPaisNacimiento');
    }
}

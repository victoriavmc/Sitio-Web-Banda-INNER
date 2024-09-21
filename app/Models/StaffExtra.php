<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffExtra extends Model
{
    protected $table = 'staffextra';
    public $timestamps = false;
    protected $primaryKey = 'idstaffExtra';
    protected $fillable = ['idstaffExtra', 'redesSociales_idredesSociales', 'usuarios_idusuarios', 'tipoStaff_idtipoStaff', 'imagenes_idimagenes'];


    // Traigo las claves foraneas de redes y usuarios
    public function redessociales()
    {
        return $this->belongsTo(redessociales::class, 'redesSociales_idredesSociales', 'idredesSociales');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_idusuarios', 'idusuarios');
    }
    public function tipoStaff()
    {
        return $this->belongsTo(TipodeStaff::class, 'tipoStaff_idtipoStaff', 'idtipoStaff');
    }

    public function imagen()
    {
        return $this->belongsTo(Imagenes::class, 'imagenes_idimagenes', 'idimagenes');
    }

    public function artistas()
    {
        return $this->hasMany(Artistas::class, 'staffextra_idstaffExtra', 'idstaffExtra');
    }
}

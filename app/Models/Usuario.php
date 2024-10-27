<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = "usuarios";
    public $timestamps = false;
    protected $primaryKey = 'idusuarios';
    protected $fillable = ['usuarioUser', 'correoElectronicoUser', 'contraseniaUser', 'rol_idrol'];

    public function datosPersonales()
    {
        return $this->hasOne(DatosPersonales::class, 'usuarios_idusuarios');
    }

    public function reportes()
    {
        return $this->hasOne(Reportes::class, 'usuarios_idusuarios');
    }

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'rol_idrol', 'idrol');
    }

    public function revisionImagenes()
    {
        return $this->hasMany(RevisionImagenes::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function staffExtra()
    {
        return $this->hasOne(StaffExtra::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function getAuthIdentifierName()
    {
        // Este método le indica a Laravel qué campo de la base de datos debe usar como identificador del usuario.
        // En lugar de utilizar el campo predeterminado 'email', se utiliza 'correoElectronicoUser'.

        return 'correoElectronicoUser';
    }

    public function getAuthPassword()
    {
        // Este método le indica a Laravel qué campo de la base de datos debe usar para obtener la contraseña del usuario.
        // En lugar de utilizar el campo predeterminado 'password', se utiliza 'contraseniaUser', que es el campo personalizado.
        return $this->contraseniaUser;
    }

    public function ordenpago()
    {
        return $this->hasOne(ordenpago::class, 'usuarios_idusuarios', 'idusuarios');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificaciones::class, 'usuarios_idusuarios');
    }
}

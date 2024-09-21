<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    public $timestamps = false;
    protected $primaryKey = 'idrol';

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'rol_idrol', 'idrol');
    }
}

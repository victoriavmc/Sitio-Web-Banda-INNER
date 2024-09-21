<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionShow extends Model
{
    protected $table = 'ubicacionshow';
    protected $primaryKey = 'idubicacionShow';
    public $timestamps = false;

    public function shows()
    {
        return $this->hasMany(Show::class, 'ubicacionShow_idubicacionShow', 'idubicacionShow');
    }
}

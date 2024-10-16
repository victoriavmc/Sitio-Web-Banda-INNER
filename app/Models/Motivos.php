<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivos extends Model
{
    use HasFactory;

    protected $table = 'motivos';
    public $timestamps = false;
    protected $primaryKey = 'idmotivos';


    public function reportes()
    {
        return $this->hasOne(Reportes::class, 'motivos_idmotivos', 'idmotivos');
    }
}

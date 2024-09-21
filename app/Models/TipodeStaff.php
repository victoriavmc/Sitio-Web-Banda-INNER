<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipodeStaff extends Model
{
    protected $table = 'tipostaff';
    public $timestamps = false;
    protected $primaryKey = 'idtipoStaff';

    public function staffextra()
    {
        return $this->hasOne(StaffExtra::class, 'tipoStaff_idtipoStaff', 'idtipoStaff');
    }
}

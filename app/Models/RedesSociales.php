<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedesSociales extends Model
{
    use HasFactory;

    protected $table = 'redessociales';
    protected $primaryKey = 'idredesSociales';
    protected $fillable = ['nombreRedSocial', 'linkRedsocial'];
    public $timestamps = false;

    public function staffextra()
    {
        return $this->hasOne(StaffExtra::class, 'redesSociales_idredesSociales', 'idredesSociales');
    }
}

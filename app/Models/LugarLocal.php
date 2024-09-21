<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarLocal extends Model
{
    protected $table = 'lugarlocal';
    protected $primaryKey = 'idlugarLocal';
    public $timestamps = false;

    public function shows()
    {
        return $this->hasMany(Show::class, 'lugarLocal_idlugarLocal', 'idlugarLocal');
    }
}

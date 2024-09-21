<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancion extends Model
{
    protected $table = 'cancion';
    protected $primaryKey = 'idcancion';
    public $timestamps = false;

    public function albumMusical()
    {
        return $this->belongsTo(AlbumMusical::class, 'albumMusical_albumMusicalcol', 'albumMusicalcol');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\albumMusical;

class AlbumDatos extends Model
{
    protected $table = 'albumdatos';
    protected $primaryKey = 'idalbumDatos';
    public $timestamps = false;

    public function albumMusical()
    {
        return $this->hasMany(AlbumMusical::class, 'albumDatos_idalbumDatos', 'idalbumDatos');
    }

    public function albumImagenes()
    {
        return $this->hasMany(AlbumImagenes::class, 'albumDatos_idalbumDatos', 'idalbumDatos');
    }
    
    public function albumVideos()
    {
        return $this->hasMany(AlbumVideo::class, 'albumDatos_idalbumDatos', 'idalbumDatos');
    }
}

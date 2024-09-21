<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumVideo extends Model
{
    protected $table = 'albumVideo';
    protected $primaryKey = 'idalbumVideo';
    public $timestamps = false;

    // Relación con AlbumDatos
    public function albumDatos()
    {
        return $this->belongsTo(AlbumDatos::class, 'albumDatos_idalbumDatos', 'idalbumDatos');
    }

    // Relación con Videos
    public function videos()
    {
        return $this->belongsTo(Videos::class, 'videos_idvideos', 'idvideos');
    }
}

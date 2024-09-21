<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $table = 'videos';
    protected $primaryKey = 'idvideos';
    public $timestamps = false;

    public function albumVideos()
    {
        return $this->hasMany(AlbumVideo::class, 'videos_idvideos', 'idvideos');
    }
}

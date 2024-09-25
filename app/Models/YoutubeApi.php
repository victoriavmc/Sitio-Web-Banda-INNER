<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeApi extends Model
{
    protected $table = 'youtubeapi';
    protected $primaryKey = 'idYoutubeApi';
    public $timestamps = false;
}

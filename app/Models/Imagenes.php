<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenes extends Model
{
    use HasFactory;

    protected $table = "imagenes";
    protected $primaryKey = 'idimagenes';
    public $timestamps = false;

    protected $fillable = ['subidaImg', 'fechaSubidaImg'];

    public function revisionImagenes()
    {
        return $this->hasMany(RevisionImagenes::class, 'imagenes_idimagenes', 'idimagenes');
    }

    public function staffExtra()
    {
        return $this->belongsTo(staffExtra::class, 'imagenes_idimagenes', 'idimagenes');
    }
}

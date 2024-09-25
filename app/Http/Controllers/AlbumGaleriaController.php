<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlbumGaleriaController extends Controller
{
    public function indexAlbumGaleria()
    {
        return view('.utils.albumGaleria.albumGaleria');
    }
}

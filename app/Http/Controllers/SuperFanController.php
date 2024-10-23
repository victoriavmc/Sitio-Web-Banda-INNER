<?php

namespace App\Http\Controllers;

use App\Models\AlbumDatos;
use App\Models\AlbumImagenes;
use App\Models\AlbumMusical;
use App\Models\AlbumVideo;
use App\Models\Cancion;
use App\Models\Precio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SuperFanController extends Controller
{
    public function indexSuperFan()
    {
        return view('content.superFan');
    }

    // Método para mostrar la vista de descargas
    public function descargas()
    {
        // Album de datos para el título con su fecha
        $albumDatos = AlbumDatos::all();

        // Crear un array para almacenar la información de todos los álbumes
        $albumInfo = [];

        foreach ($albumDatos as $albumDato) {
            // Almacenar el título y la fecha del álbum
            $tituloAlbum = $albumDato->tituloAlbum;
            $fechaAlbum = $albumDato->fechaAlbum;

            // Relacionar con subidas de imágenes
            $albumImagen = AlbumImagenes::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            $imagenes = []; // Array para almacenar la información de las imágenes
            foreach ($albumImagen as $imagen) {
                $imagenes[] = [
                    'idImagen' => $imagen->idalbumImagen,
                    'rutaImagen' => $imagen->revisionImagenes->imagenes->subidaImg ?? 'ruta/default.jpg',
                    'descargaImagen' => $imagen->revisionImagenes->imagenes->contenidoDescargable ?? '#',
                ];
            }

            // Relacionar con videos
            $albumVideos = AlbumVideo::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            $videos = []; // Array para almacenar la información de los videos
            foreach ($albumVideos as $video) {
                $videos[] = [
                    'idVideo' => $video->idalbumVideo,
                    'rutaVideo' => $video->videos->subidaVideo ?? 'ruta/default.mp4',
                    'descargaVideo' => $video->videos->contenidoDescargable ?? '#',
                ];
            }

            // Relacionar con canciones
            $albumMusical = AlbumMusical::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            $canciones = []; // Array para almacenar la información de las canciones
            foreach ($albumMusical as $musica) {
                $idMusica = $musica->idalbumMusical;

                $cancionesAlbum = Cancion::where('albumMusical_idalbumMusical', $idMusica)->get();

                foreach ($cancionesAlbum as $cancion) {
                    $canciones[] = [
                        'idCancion' => $cancion->idcancion,
                        'rutaCancion' => $cancion->archivoDsCancion ?? 'ruta/default.mp3',
                        'descargaCancion' => $cancion->contenidoDescargable ?? '#',
                    ];
                }
            }

            // Agregar toda la información del álbum al array principal
            $albumInfo[] = [
                'tituloAlbum' => $tituloAlbum,
                'fechaAlbum' => $fechaAlbum,
                'imagenes' => $imagenes,
                'videos' => $videos,
                'canciones' => $canciones,
            ];
        }

        // Retornar la vista con la información de los álbumes
        return view('content.descargas', ['albumInfo' => $albumInfo]);
    }


    public function precioAgregar() {}

    public function precioModificar() {}

    public function precioMostrarTodosLosCargados() {}

    public function precioMostrar()
    {
        // Traigo el precio de la base de datos
        $ultimoPrecio = Precio::orderBy('idprecio', 'desc')->first();
    }
}

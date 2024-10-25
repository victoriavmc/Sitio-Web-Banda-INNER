<?php

namespace App\Http\Controllers;

use App\Models\AlbumDatos;
use App\Models\AlbumImagenes;
use App\Models\AlbumMusical;
use App\Models\AlbumVideo;
use App\Models\Cancion;
use App\Models\Imagenes;
use App\Models\Precio;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SuperFanController extends Controller
{
    public function indexSuperFan()
    {
        $media = $this->descargaVer();
        return view('content.superFan', ['media' => $media]);
    }

    //modificarPara Descargar
    public function descargarAlbumMusical(Request $request)
    {
        $tipo = $request->input('tipo');
        $idEspecifico = $request->input('idEspecifico');
        $descarga = $request->input('descarga');

        switch ($tipo) {
            case 'Imagen':
                $msj = 'La imagen ahora ';
                $obj = AlbumImagenes::find($idEspecifico);
                $idObj = $obj->revisionImagenes->imagenes_idimagenes;
                $obj = Imagenes::find($idObj);
                break;
            case 'Video':
                $msj = 'El video ahora ';
                $obj = AlbumVideo::find($idEspecifico);
                $idObj = $obj->videos_idvideos;
                $obj = Videos::find($idObj);
                break;
            case 'Cancion':
                $msj = 'La canción ahora ';
                $obj = Cancion::find($idEspecifico);
                break;
        }

        if ($obj) {
            if ($descarga == 'No') {
                $msj2 = 'se puede descargar.';
                $obj->contenidoDescargable = 'Sí';
            } elseif ($descarga == 'Sí') {
                $msj2 = 'NO se puede descargar.';
                $obj->contenidoDescargable = 'No';
            }
            $obj->save();

            return redirect()->back()->with('alertAlbum', [
                'type' => 'Success',
                'message' => $msj . $msj2
            ]);
        }
    }

    // Método para mostrar la vista de descargas
    public function descargas()
    {
        // Album de datos para el título con su fecha
        $albumDatos = AlbumDatos::all();
        // Determinar el tipo de contenido del álbum
        $tipo = [];
        // Array para almacenar la información de las imágenes
        $media = [];
        foreach ($albumDatos as $albumDato) {
            // Almacenar el título y la fecha del álbum
            $tituloAlbum = $albumDato->tituloAlbum;
            $fechaAlbum = $albumDato->fechaSubido;

            // Relacionar con subidas de imágenes
            $albumImagen = AlbumImagenes::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();


            foreach ($albumImagen as $imagen) {
                $tipo = 'Imagen';
                $media[] = [
                    'tipo' => $tipo,
                    'tituloAlbum' => $tituloAlbum,
                    'fechaAlbum' => $fechaAlbum,
                    'id' => $imagen->albumImagenescol,
                    'ruta' => $imagen->revisionImagenes->imagenes->subidaImg ?? 'ruta/default',
                    'descarga' => $imagen->revisionImagenes->imagenes->contenidoDescargable ?? '#',

                ];
            }

            // Relacionar con videos
            $albumVideos = AlbumVideo::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            foreach ($albumVideos as $video) {
                $tipo = 'Video';
                $media[] = [
                    'tipo' => $tipo,
                    'tituloAlbum' => $tituloAlbum,
                    'fechaAlbum' => $fechaAlbum,
                    'id' => $video->idalbumVideo,
                    'ruta' => $video->videos->subidaVideo ?? 'ruta/default',
                    'descarga' => $video->videos->contenidoDescargable ?? '#',
                ];
            }

            // Relacionar con canciones
            $albumMusical = AlbumMusical::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            foreach ($albumMusical as $musica) {
                $idMusica = $musica->idalbumMusical;

                $cancionesAlbum = Cancion::where('albumMusical_idalbumMusical', $idMusica)->get();

                foreach ($cancionesAlbum as $cancion) {
                    $titulo = $tituloAlbum . ' - ' . $cancion->tituloCancion;
                    $tipo = 'Cancion';
                    $media[] = [
                        'tipo' => $tipo,
                        'tituloAlbum' => $titulo,
                        'fechaAlbum' => $fechaAlbum,
                        'id' => $cancion->idcancion,
                        'ruta' => $cancion->archivoDsCancion ?? 'ruta/default',
                        'descarga' => $cancion->contenidoDescargable ?? '#',
                    ];
                }
            }
        }

        // Retornar la vista con la información de los álbumes
        return view('content.descargas', ['media' => $media]);
    }

    //Ver solo lo que esta disponible descargar
    public function descargaVer()
    {
        // Album de datos para el título con su fecha
        $albumDatos = AlbumDatos::all();
        // Determinar el tipo de contenido del álbum
        $tipo = [];
        // Array para almacenar la información de las imágenes
        $media = [];
        foreach ($albumDatos as $albumDato) {
            // Almacenar el título y la fecha del álbum
            $tituloAlbum = $albumDato->tituloAlbum;
            $fechaAlbum = $albumDato->fechaSubido;

            // Relacionar con subidas de imágenes
            $albumImagen = AlbumImagenes::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            foreach ($albumImagen as $imagen) {
                $idImagen = $imagen->revisionImagenes->imagenes_idimagenes;
                $imagen2 = Imagenes::where('idimagenes', $idImagen)->where('contenidoDescargable', 'Sí')->get();
                foreach ($imagen2 as $imagenG) {
                    $tipo = 'Imagen';
                    $media[] = [
                        'tipo' => $tipo,
                        'tituloAlbum' => $tituloAlbum,
                        'fechaAlbum' => $fechaAlbum,
                        'id' => $imagen->albumImagenescol,
                        'ruta' => $imagen->revisionImagenes->imagenes->subidaImg ?? 'ruta/default',
                    ];
                }
            }

            // Relacionar con videos
            $albumVideos = AlbumVideo::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            foreach ($albumVideos as $video) {
                $idVideo = $video->videos_idvideos;
                $albumVideos = Videos::where('idvideos', $idVideo)->where('contenidoDescargable', 'Sí')->get();
                $tipo = 'Video';
                $media[] = [
                    'tipo' => $tipo,
                    'tituloAlbum' => $tituloAlbum,
                    'fechaAlbum' => $fechaAlbum,
                    'id' => $video->idalbumVideo,
                    'ruta' => $video->videos->subidaVideo ?? 'ruta/default',
                ];
            }

            // Relacionar con canciones
            $albumMusical = AlbumMusical::where('albumDatos_idalbumDatos', $albumDato->idalbumDatos)->get();

            foreach ($albumMusical as $musica) {
                $idMusica = $musica->idalbumMusical;
                $fotoAlbum = $musica->revisionimagenes->imagenes->subidaImg ?? 'ruta/default';
                $cancionesAlbum = Cancion::where('albumMusical_idalbumMusical', $idMusica)->where('contenidoDescargable', 'Sí')->get();

                foreach ($cancionesAlbum as $cancion) {
                    $titulo = $tituloAlbum . ' - ' . $cancion->tituloCancion;
                    $tipo = 'Cancion';
                    $media[] = [
                        'tipo' => $tipo,
                        'tituloAlbum' => $titulo,
                        'fechaAlbum' => $fechaAlbum,
                        'fotoAlbum' => $fotoAlbum,
                        'id' => $cancion->idcancion,
                        'ruta' => $cancion->archivoDsCancion ?? 'ruta/default',
                    ];
                }
            }
        }
        // Retornar la información de los álbumes que se puedan descargar
        return $media;
    }
}

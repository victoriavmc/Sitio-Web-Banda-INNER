<?php

namespace App\Http\Controllers;

#Clases
use App\Models\AlbumDatos;
use App\Models\AlbumMusical;
use App\Models\Cancion;
use App\Models\Imagenes;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;

#Otros
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;

class AlbumMusicaController extends Controller
{
    public $links;

    public function indexAlbumMusica()
    {
        $listaAlbum = $this->mostrarAlbumnes();
        return view('utils.albumMusica.discografia', compact('listaAlbum'));
    }

    public function mostrarAlbumnes()
    {
        $listaAlbum = [];

        // Obtener todos los álbumes
        $albumes = AlbumMusical::all();

        // Recorrer cada álbum y extraer los datos
        foreach ($albumes as $album) {
            // Verificar si las relaciones existen para evitar errores
            $idalbum = $album->idalbumMusical ?? 'ID No disponible';
            $idAlbumDatos = $album->albumdatos->idalbumDatos  ?? 'ID No disponible';
            $albumTitulo = $album->albumdatos->tituloAlbum ?? 'Título no disponible';
            $albumFecha = $album->albumdatos->fechaSubido ?? 'Fecha no disponible';
            $albumImagen = $album->revisionimagenes->imagenes->subidaImg ?? 'logo_inner.webp';

            // Inicializar la lista de canciones para cada álbum
            $listacanciones = [];

            // Obtener las canciones relacionadas con el álbum
            $canciones = Cancion::where('albumMusical_idalbumMusical', $idalbum)->get();

            // Verificar si hay canciones antes de recorrer
            if ($canciones) {
                foreach ($canciones as $cancion) {

                    // Añadir los detalles de la canción: nombre, letra en español y letra en inglés
                    $listacanciones[] = [
                        'id' => $cancion->idcancion,
                        'titulo' => $cancion->tituloCancion,
                        'letra_en_espanol' => $cancion->letraEspCancion ?? 'Letra en español no disponible',
                        'letra_en_ingles' => $cancion->letraInglesCancion ?? 'Letra en inglés no disponible',
                    ];
                }
            }

            // Agregar los datos del álbum junto con las canciones
            $listaAlbum[] = [
                'idAlbumDatos' => $idAlbumDatos,
                'id' => $idalbum,
                'titulo' => $albumTitulo,
                'fecha' => $albumFecha,
                'imagen' => $albumImagen,
                'canciones' => $listacanciones, // Guardar los detalles completos de las canciones
            ];
        }

        return $listaAlbum;
    }

    #Recupero las redes y muestro en la vista
    public function linksRedes()
    {
        return $this->links = RedesSociales::whereRaw('nombreRedSocial NOT REGEXP "^[0-9]"')->get();
    }

    //Redirecciona a la cancion
    public function verCancion($id)
    {
        // Buscar la canción por ID
        $cancion = Cancion::findOrFail($id);
        $datosCancion = $cancion;

        // Obtener el ID del álbum al que pertenece la canción
        $idAlbum = $cancion->albumMusical_idalbumMusical;
        // Buscar el álbum usando el ID obtenido
        $album = AlbumMusical::findOrFail($idAlbum);
        // Obtener el título del álbum
        $tituloAlbum = $album->albumDatos->tituloAlbum;
        // Agregamos la imagen del album
        $albumImagen = $album->revisionimagenes->imagenes->subidaImg ?? 'logo_inner.webp';
        // Inicializar la lista de canciones para el álbum
        $listaCanciones = [];
        // Obtener las canciones relacionadas con el álbum, excluyendo la canción actual
        $canciones = Cancion::where('albumMusical_idalbumMusical', $idAlbum)
            ->where('idcancion', '!=', $id) // Filtrar para excluir la canción actual
            ->get();
        // Verificar si hay canciones antes de recorrer
        if ($canciones->isNotEmpty()) {
            foreach ($canciones as $cancion) {
                // Añadir los detalles de la canción: nombre, letra en español y letra en inglés
                $listaCanciones[] = [
                    'id' => $cancion->idcancion,
                    'titulo' => $cancion->tituloCancion,
                ];
            }
        }
        // Agregar los datos del álbum junto con las canciones
        $listaAlbum = [
            'id' => $idAlbum,
            'titulo' => $tituloAlbum,
            'imagen' => $albumImagen,
            'canciones' => $listaCanciones, // Guardar los detalles completos de las canciones
        ];
        #Envio RedesSociales
        $recuperoRedesSociales = $this->linksRedes();
        // Pasar los datos a la vista
        return view('utils.albumMusica.onlyCancion', compact('datosCancion', 'listaAlbum', 'recuperoRedesSociales'));
    }
}

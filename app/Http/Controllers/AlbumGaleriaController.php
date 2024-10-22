<?php

namespace App\Http\Controllers;

#Clases
use App\Models\AlbumImagenes;
use App\Models\AlbumVideo;
use App\Models\YoutubeApi;
use Carbon\Carbon;
#Otros
use Illuminate\Http\Request;

class AlbumGaleriaController extends Controller
{
    public function indexAlbumGaleria()
    {
        $listaAlbumV = $this->mostrarAlbumnes('video');
        $listaAlbumI = $this->mostrarAlbumnes('imagenes');
        $listaYt = $this->albumYt();
        return view('.utils.albumGaleria.albumGaleria', compact('listaAlbumV', 'listaAlbumI', 'listaYt'));
    }

    public function mostrarAlbumnes($tipo = 'video')
    {
        $listaAlbum = [];

        // Determinar la clase del álbum y el método de obtención según el tipo
        $albumClase = $tipo === 'video' ? AlbumVideo::class : AlbumImagenes::class;

        // Obtener todos los álbumes
        $albumes = $albumClase::all();

        // Array para controlar los álbumes procesados
        $procesados = [];

        foreach ($albumes as $album) {
            // Obtener el ID del álbum para evitar duplicados
            $idDatosAlbum = $album->albumDatos_idalbumDatos;

            // Verificar si el álbum ya se ha procesado
            if (in_array($idDatosAlbum, $procesados)) {
                continue;
            }

            // Obtener todas las entradas del álbum por el mismo `idAlbumDatos`
            $albumGrupal = $albumClase::where('albumDatos_idalbumDatos', $idDatosAlbum)->get();

            // Contar cuántos elementos existen en el álbum
            $cantidadAlbum = count($albumGrupal);

            // Obtener datos del álbum (título y fecha) del primer registro
            $albumTitulo = $albumGrupal->first()->albumDatos->tituloAlbum ?? 'Título no disponible';
            $albumFecha = $albumGrupal->first()->albumDatos->fechaSubido ?? 'Fecha no disponible';

            // Inicializar la lista de medios (videos o imágenes)
            $albumMedios = [];

            // Recorrer cada entrada del álbum para obtener los medios
            foreach ($albumGrupal as $item) {
                if ($tipo === 'video') {
                    $medio = $item->videos->subidaVideo ?? null;
                } else {
                    $medio = $item->revisionImagenes->imagenes->subidaImg ?? null;
                }

                if ($medio) {
                    $albumMedios[] = $medio;
                }
            }

            // Agregar los datos del álbum junto con los medios
            $listaAlbum[] = [
                'idAlbumEspecifico' => $idDatosAlbum,
                'titulo' => $albumTitulo,
                'fecha' => $albumFecha,
                'cantidadAlbum' => $cantidadAlbum,
                'medios' => $albumMedios ?: null,
            ];

            // Marcar este álbum como procesado
            $procesados[] = $idDatosAlbum;
        }

        return $listaAlbum;
    }

    public function albumYt()
    {
        $videos = YoutubeApi::all();
        $listaYt = [];
        foreach ($videos as $video) {
            // Convertir el link de YouTube al formato de incrustación
            $videoId = explode('v=', $video->linkYt)[1] ?? '';
            $linkYt = $videoId ? 'https://www.youtube.com/embed/' . $videoId : '#';

            $listaYt[] = [
                'titulo' => $video->tituloYt,
                'fecha' => $video->fecha,
                'linkYt' => $linkYt,
            ];
        }
        return $listaYt;
    }

    public function botonObtenerVideoYt()
    {
        // 1. Borrar todos los datos de YoutubeApi.
        YoutubeApi::truncate();

        // 2. Obtener las claves necesarias desde el archivo .env.
        $key = env('YOUTUBE_API_KEY');
        $idCanal = env('ID_YOUTUBE');

        // 3. Construir la URL de la API de YouTube.
        $json_url = 'https://www.googleapis.com/youtube/v3/search?key=' . $key . '&channelId=' . $idCanal . '&part=snippet,id&order=date&maxResults=50';

        // 4. Inicializar cURL con la URL de la API.
        $ch = curl_init($json_url);

        // 5. Configurar las opciones de cURL.
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/json'
            )
        );

        // 6. Establecer las opciones de cURL.
        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);

        $json_output = json_decode($result, true);

        foreach ($json_output["items"] as $elemento) {
            // Si es video (No lista)
            if (isset($elemento["id"]["videoId"])) {
                $urlVideo = "https://www.youtube.com/watch?v=" . $elemento["id"]["videoId"];
                $tituloVideo = $elemento["snippet"]["title"];
                // Convertir la fecha a formato MySQL
                $fechaVideo = Carbon::parse($elemento["snippet"]["publishedAt"])->format('Y-m-d H:i:s');


                // Guardar los datos en la base de datos usando el modelo YoutubeApi.
                YoutubeApi::create([
                    'tituloYt' => $tituloVideo,
                    'fecha' => $fechaVideo,
                    'linkYt' => $urlVideo,
                ]);
            }
        }
        return redirect()->back();
    }
}

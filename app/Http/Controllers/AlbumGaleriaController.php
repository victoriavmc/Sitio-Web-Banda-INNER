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
        $listaAlbumV = $this->mostrarAlbumnesVideo();
        $listaAlbumI = $this->mostrarAlbumnesImagenes();
        $listaYt = $this->albumYt();
        return view('.utils.albumGaleria.albumGaleria', compact('listaAlbumV', 'listaAlbumI', 'listaYt'));
    }

    public function mostrarAlbumnesVideo()
    {
        $listaAlbumV = [];

        // Obtener todos los álbumes de Video
        $albumes = AlbumVideo::all();

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
            $albumGrupal = AlbumVideo::where('albumDatos_idalbumDatos', $idDatosAlbum)->get();

            // Obtener datos del álbum (título y fecha) del primer registro
            $albumTitulo = $albumGrupal->first()->albumDatos->tituloAlbum ?? 'Título no disponible';
            $albumFecha = $albumGrupal->first()->albumDatos->fechaSubido ?? 'Fecha no disponible';

            // Inicializar la lista de videos
            $albumVideos = [];

            // Recorrer cada entrada del álbum para obtener los videos
            foreach ($albumGrupal as $item) {
                $video = $item->videos->subidaVideo ?? null; // Obtener el video o nulo si no existe
                if ($video) {
                    $albumVideos[] = $video;
                }
            }

            // Agregar los datos del álbum junto con los videos
            $listaAlbumV[] = [
                'titulo' => $albumTitulo,
                'fecha' => $albumFecha,
                'videos' => $albumVideos ?: null, // Si no hay videos, establecer como nulo
            ];

            // Marcar este álbum como procesado
            $procesados[] = $idDatosAlbum;
        }

        return $listaAlbumV;
    }

    public function mostrarAlbumnesImagenes()
    {
        $listaAlbumI = [];

        // Obtener todos los álbumes de Imágenes
        $albumes = AlbumImagenes::all();

        // Array para controlar los álbumes procesados
        $procesados = [];

        foreach ($albumes as $album) {
            // Verificar si el álbum ya se ha procesado
            $idDatosAlbum = $album->albumDatos_idalbumDatos;
            if (in_array($idDatosAlbum, $procesados)) {
                continue;
            }
            // Obtener todas las imágenes relacionadas al mismo `idAlbumDatos`
            $albumGrupal = AlbumImagenes::where('albumDatos_idalbumDatos', $idDatosAlbum)->get();

            // Obtener datos de álbum (título y fecha) del primer registro
            $albumTitulo = $albumGrupal->first()->albumDatos->tituloAlbum;
            $albumFecha = $albumGrupal->first()->albumDatos->fechaSubido;

            // Obtener todas las imágenes de este álbum
            $albumImagenes = [];
            foreach ($albumGrupal as $item) {
                $imagen = $item->revisionImagenes->imagenes->subidaImg ?? null;
                if ($imagen) {
                    $albumImagenes[] = $imagen;
                }
            }

            // Agregar los datos del álbum junto con las imágenes
            $listaAlbumI[] = [
                'titulo' => $albumTitulo,
                'fecha' => $albumFecha,
                'imagenes' => $albumImagenes ?: null,
            ];

            // Marcar este álbum como procesado
            $procesados[] = $idDatosAlbum;
        }

        return $listaAlbumI;
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

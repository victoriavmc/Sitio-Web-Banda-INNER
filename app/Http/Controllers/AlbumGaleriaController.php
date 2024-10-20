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

        // Recorrer cada álbum y extraer los datos
        foreach ($albumes as $album) {
            // Verificar si las relaciones existen para evitar errores
            $albumTitulo = $album->albumdatos->tituloAlbum ?? 'Título no disponible';
            $albumFecha = $album->albumdatos->fechaAlbum ?? 'Fecha no disponible';

            // Obtener videos asociados al álbum
            $videos = $album->videos ?? [];

            // Inicializar la lista de videos
            $albumVideos = [];

            // Verificar si hay videos antes de recorrer
            if (count($videos) > 0) {
                foreach ($videos as $video) {
                    $albumVideos[] = $video->subidaVideo ?? null; // Si no hay video, es nulo
                }
            } else {
                // Si no hay videos, establecer el valor como nulo
                $albumVideos = null;
            }

            // Agregar los datos del álbum junto con los videos
            $listaAlbumV[] = [
                'titulo' => $albumTitulo,
                'fecha' => $albumFecha,
                'videos' => $albumVideos,
            ];
        }

        return $listaAlbumV;
    }

    public function mostrarAlbumnesImagenes()
    {
        $listaAlbumI = [];

        // Obtener todos los álbumes de Imágenes
        $albumes = AlbumImagenes::all();

        // Recorrer cada álbum y extraer los datos
        foreach ($albumes as $album) {
            // Verificar si las relaciones existen para evitar errores
            $albumTitulo = $album->albumdatos->tituloAlbum ?? 'Título no disponible';
            $albumFecha = $album->albumdatos->fechaAlbum ?? 'Fecha no disponible';

            // Verificar si la relación 'revisionimagenes' existe
            $imagenes = $album->revisionimagenes->imagenes ?? [];

            // Inicializar la lista de imágenes
            $albumImagenes = [];

            // Verificar si hay imágenes antes de recorrer
            if (count($imagenes) > 0) {
                foreach ($imagenes as $imagen) {
                    $albumImagenes[] = $imagen->subidaimagen ?? null; // Si no hay imagen, es nulo
                }
            } else {
                // Si no hay imágenes, establecer el valor como nulo
                $albumImagenes = null;
            }

            // Agregar los datos del álbum junto con las imágenes
            $listaAlbumI[] = [
                'titulo' => $albumTitulo,
                'fecha' => $albumFecha,
                'imagen' => $albumImagenes,
            ];
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

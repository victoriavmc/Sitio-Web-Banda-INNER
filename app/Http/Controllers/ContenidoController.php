<?php

namespace App\Http\Controllers;

#CLASES
use App\Models\Actividad;
use App\Models\Contenidos;
use App\Models\Imagenes;
use App\Models\ImagenesContenido;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;

#OTROS
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ContenidoController extends Controller
{
    public $links;

    #DESCRIPCION REDUCIDA
    public function contenidosReducidos($dato)
    {
        // Ordenar por fechaSubida, descendente
        $recuperoPublicaciones = Contenidos::where('tipoContenido_idtipoContenido', $dato)->orderBy('fechaSubida', 'desc')->get();

        // Limitar la descripción a 40 palabras
        foreach ($recuperoPublicaciones as $publicacion) {
            $publicacion->descripcion = Str::words($publicacion->descripcion, 30);
        }

        return $recuperoPublicaciones;
    }

    #Recupero las redes y muestro en la vista
    public function linksRedes()
    {
        return $this->links = RedesSociales::whereRaw('nombreRedSocial NOT REGEXP "^[0-9]"')->get();
    }
    # IMAGENES CONTENIDO
    public function ImagenesContenido($idContent)
    {
        # Tengo que recuperar todas las imagen que coincidan con el idcontendio.
        $imagenes = ImagenesContenido::where('contenidos_idcontenidos', $idContent)->get();

        $rutasImg = []; // Array para almacenar las rutas de las imágenes

        foreach ($imagenes as $imgEspecifica) {
            # Obtengo el id/ids
            $idRevImg = $imgEspecifica->revisionImagenes_idrevisionImagenescol;

            # Revisión Imagenes para obtener el id de la imagen
            $revisionImagenes = RevisionImagenes::where('idrevisionImagenescol', $idRevImg)->first();

            if ($revisionImagenes) {
                // Obtengo IdImagen
                $idImagen = $revisionImagenes->imagenes_idimagenes;

                // Entro a la tabla de imágenes
                $imagen = Imagenes::where('idimagenes', $idImagen)->first();

                if ($imagen) {
                    // Obtengo la ruta de la imagen
                    $rutaImg = $imagen->subidaImg;

                    // Almaceno la ruta en el array
                    $rutasImg[] = $rutaImg; // Guardo las rutas sin clave para simplificar
                }
            }
        }
        # Devuelvo las rutas de la imagen
        return $rutasImg;
    }

    #Solo Obtengo PUBLICACIONES DEL FORO-NOTICIAS-BIOGRAFIA
    public function getPublicaciones($dato)
    {
        // Ordenar por fechaSubida, descendente
        $recuperoPublicaciones = Contenidos::where('tipoContenido_idtipoContenido', $dato)->orderBy('fechaSubida', 'desc')->get();
        return $recuperoPublicaciones;
    }

    ## FORO
    # ENVIO A LA VISTA LAS PUBLICACIONES DEL FORO
    public function indexForo()
    {
        #Recupero solo publicaciones Foro
        $recuperoPublicaciones = $this->contenidosReducidos(1);
        $recuperoLikes = $this->contadorEstrellasVisual();

        return view('/content/forum/foro', compact('recuperoPublicaciones', 'recuperoLikes'));
    }

    # VER PUNTUACIONES DEL FORO
    public function contadorEstrellas()
    {
        $likesDislikes = [];

        #Recupero solo publicaciones Foro
        $recuperoPublicaciones = $this->getPublicaciones(1);

        #Obtener los idActividad y idcontenido
        foreach ($recuperoPublicaciones as $publicacion) {
            $idGustacion = $publicacion->Actividad_idActividad;

            #Recupero la actividad que realizaron
            $mostrarActividad = Actividad::where('idActividad', $idGustacion)->first();

            # Almaceno la puntuacion que le dio
            $likesDislikes[$publicacion->idcontenidos] = [
                'like' => $mostrarActividad->contadorMg,
                'dislike' => $mostrarActividad->contadorNM,
            ];
        }

        return $likesDislikes;
    }

    #Visualmente Puntuacion de Foro
    public function contadorEstrellasVisual()
    {
        $contabilizar = $this->contadorEstrellas();
        # Arreglo para almacenar la visualización de las estrellas
        $estrellasVisuales = [];

        #Recorro las publicaciones
        foreach ($contabilizar as $idPublicacion => $data) {
            $datoLike = $data['like'];
            $datoDislike = $data['dislike'];

            # Calculo la puntuación total
            $total = $datoLike + $datoDislike;

            #Datos de las estrellas
            $estrellasLlenas = 0;
            $estrellasMedias = 0;

            if ($total > 0) {
                $media = $datoLike / $total;
                $cantEstrellas = $media * 5;
                $estrellasLlenas = floor($cantEstrellas);
                $estrellasMedias = ($cantEstrellas - $estrellasLlenas >= 0.5) ? 1 : 0;
            }

            $estrellasVacias = 5 - $estrellasLlenas - $estrellasMedias;

            # Almaceno la visualización en el arreglo
            $estrellasVisuales[$idPublicacion] = [
                'estrellasLlenas' => $estrellasLlenas,
                'estrellasMedias' => $estrellasMedias,
                'estrellasVacias' => $estrellasVacias,
                'like' => $datoLike,
                'dislike' =>  $datoDislike,
            ];
        }
        return $estrellasVisuales;
    }

    ## NOTICIAS
    # ENVIO A LA VISTA LAS PUBLICACIONES DE LAS NOTICIAS
    public function indexNoticias()
    {
        #Recupero solo publicaciones de Noticias
        $recuperoNoticias = $this->contenidosReducidos(2);

        #Recorro las publicaciones
        foreach ($recuperoNoticias as $noticias) {
            # Obtengo el id de noticias
            $noticias->imagenes = $this->ImagenesContenido($noticias->idcontenidos);
        }

        return view('/content/news/noticias', compact('recuperoNoticias'));
    }

    ## BIOGRAFIA
    # ENVIO A LA VISTA LAS PUBLICACIONES DEL BIOGRAFIA
    public function indexBiografia()
    {
        #Envio RedesSociales
        $recuperoRedesSociales = $this->linksRedes();
        # Recupero solo publicaciones de Biografia
        $recuperoBiografia = $this->getPublicaciones(3);

        foreach ($recuperoBiografia as $biografia) {
            # Obtener las imágenes y asignarlas al objeto $biografia
            $biografia->imagenes = $this->ImagenesContenido($biografia->idcontenidos);
        }

        return view('/content/history/biografia', compact('recuperoRedesSociales', 'recuperoBiografia'));
    }
}

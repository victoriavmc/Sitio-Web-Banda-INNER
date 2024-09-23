<?php

namespace App\Http\Controllers;

#CLASES
use App\Models\Actividad;
use App\Models\Comentarios;
use App\Models\Contenidos;
use App\Models\Imagenes;
use App\Models\ImagenesContenido;
use App\Models\LugarLocal;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use App\Models\Usuario;

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
        return Contenidos::where('tipoContenido_idtipoContenido', $dato)
            ->orderBy('fechaSubida', 'desc')
            ->get()
            // El método 'map' se utiliza para transformar cada elemento de una colección aplicando una función a cada uno de ellos, devolviendo una nueva colección con los resultados
            ->map(function ($publicacion) {
                $publicacion->descripcion = Str::words($publicacion->descripcion, 30);
                return $publicacion;
            });
    }

    #Recupero las redes y muestro en la vista
    public function linksRedes()
    {
        return $this->links = RedesSociales::whereRaw('nombreRedSocial NOT REGEXP "^[0-9]"')->get();
    }

    # IMAGENES CONTENIDO
    public function ImagenesContenido($idContent, $opcion)
    {
        $rutasImg = []; // Array para almacenar las rutas de las imágenes
        if ($opcion == 1) {
            # Tengo que recuperar todas las imagen que coincidan con el idcontendio.
            $imagenes = ImagenesContenido::where('contenidos_idcontenidos', $idContent)->get();

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
        } elseif ($opcion == 2) {
            # Tengo que recuperar la imagen que conincida el id de la tabla revision imagen
            $revisionImagenes = RevisionImagenes::find($idContent);
            #Obtengo la imagen
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

    #Recupero el Perfil Usuario
    public function usuarioAutor($idContent, $opcion)
    {
        if ($opcion == 1) {
            // Recuperamos la publicación por su ID
            $recuperoPublicacion = Contenidos::find($idContent);

            // Obtenemos el ID del usuario asociado a la publicación
            $idUser = $recuperoPublicacion->usuarios_idusuarios;

            // Obtenemos la información completa del autor
            $autor = Usuario::where('idusuarios', $idUser)->first();

            // Obtenemos la imagen de perfil del usuario (tipo de foto 1)
            $imagenUsuarioPerfil = RevisionImagenes::where('usuarios_idusuarios', $idUser)
                ->where('tipodefoto_idtipoDeFoto', 1)
                ->first();

            // Si existe una imagen de perfil asociada, obtenemos la ruta
            if ($imagenUsuarioPerfil) {
                $idImagen = $imagenUsuarioPerfil->imagenes_idimagenes;
                $imagenPerfil = Imagenes::where('idimagenes', $idImagen)->first();

                // Si existe la imagen, devolvemos la ruta
                if ($imagenPerfil) {
                    $rutaImg = $imagenPerfil->subidaImg;
                } else {
                    $rutaImg = []; // Ruta nula
                }
            } else {
                $rutaImg = []; // Ruta nula
            }

            // Devolvemos el usuario junto con la ruta de su imagen
            return [
                'usuario' => $autor,
                'ruta_imagen' => $rutaImg
            ];
        } elseif ($opcion == 2) {
            // Obtenemos la información completa del autor
            $autor = Usuario::where('idusuarios', $idContent)->first();

            // Obtenemos la imagen de perfil del usuario (tipo de foto 1)
            $imagenUsuarioPerfil = RevisionImagenes::where('usuarios_idusuarios', $idContent)
                ->where('tipodefoto_idtipoDeFoto', 1)
                ->first();

            // Si existe una imagen de perfil asociada, obtenemos la ruta
            if ($imagenUsuarioPerfil) {
                $idImagen = $imagenUsuarioPerfil->imagenes_idimagenes;
                $imagenPerfil = Imagenes::where('idimagenes', $idImagen)->first();

                // Si existe la imagen, devolvemos la ruta
                if ($imagenPerfil) {
                    $rutaImg = $imagenPerfil->subidaImg;
                } else {
                    $rutaImg = []; // Ruta nula
                }
            } else {
                $rutaImg = []; // Ruta nula
            }

            // Devolvemos el usuario junto con la ruta de su imagen
            return [
                'usuario' => $autor,
                'ruta_imagen' => $rutaImg
            ];
        }
    }

    #Like y dislike de Publicacion especifica
    public function likeDislike($idContent)
    {
        // Recuperamos la publicación por su ID
        $recuperoPublicacion = Contenidos::find($idContent);
        // Obtenemos el ID del usuario asociado a la publicación
        $recuperoIdMg = $recuperoPublicacion->Actividad_idActividad;

        $respuestas = Actividad::find($recuperoIdMg);

        return [
            'contadorMg' => $respuestas->contadorMg,
            'contadorNM' =>  $respuestas->contadorNM,
            'contadorReport' =>  $respuestas->reporte,
        ];
    }

    #Comentarios
    public function comentariosActividad($idContent)
    {
        #Comentarios entro a la tabla, para relacionar a la actividad que corresponde al contenido especifico
        $comentarios = Comentarios::where('contenidos_idcontenidos', $idContent)->get();

        # Array para almacenar la información de cada comentario
        $resultadoComentarios = [];
        #tengo que visualizar el comentario con las actividades que presenta cada una
        foreach ($comentarios as $comentario) {
            #Recuperar idCadaComentarioIndivididual y quien realiza el comentario
            $idUser = $comentario->usuarios_idusuarios;
            $idRevisionImg = $comentario->revisionImagenes_idrevisionImagenescol;

            #Recuperar el usuario que comento:
            $autorComentario = $this->usuarioAutor($idUser, 2);

            #Recuperar la imagen de la tabla Revision Imagenes
            $rutaImagen = $this->ImagenesContenido($idRevisionImg, 2);

            #Envio todos los datos de los comentarios toda el array de autor y el array de la imagen unica de ruta 
            # Formar el array con la información completa del comentario
            $resultadoComentarios[] = [
                'comentario' => $comentario,         // Detalles del comentario
                'autor' => $autorComentario['usuario'],  // Información del usuario que comentó
                'imagenAutor' => $autorComentario['ruta_imagen'],  // Imagen de perfil del usuario
                'imagenComentario' => $rutaImagen   // Imagen asociada al comentario (si existe)
            ];
        }

        # Retornar los comentarios como una colección
        return collect($resultadoComentarios);
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
        $comentarios = $this->contadorComentarios();
        return view('/content/forum/foro', compact('recuperoPublicaciones', 'recuperoLikes', 'comentarios'));
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

    #Cuenta comentarios de cada publicacion
    public function contadorComentarios()
    {
        #Recupero solo publicaciones Foro
        $recuperoPublicaciones = $this->getPublicaciones(1);

        #Obtener los idActividad y idcontenido
        foreach ($recuperoPublicaciones as $publicacion) {
            $idGustacion = $publicacion->Actividad_idActividad;

            #Recupero la actividad que realizaron
            $mostrarActividad = Actividad::where('idActividad', $idGustacion)->first();

            #Recupero los Comentarios que coincidan con ese Contenido
            $recuperoComentarios = Comentarios::where('contenidos_idcontenidos', $idGustacion)->get();

            #Cuento la cantidad de comentarios que realizaron en esa publicion
            $contadorComentarios = count($recuperoComentarios);


            # Almaceno la puntuacion que le dio
            $contarComentarios[$publicacion->idcontenidos] = [
                'comentarios' => $contadorComentarios,
            ];
        }
        return $contarComentarios;
    }

    #Ver de a uno FORO
    public function publicacionUnicaForo($data)
    {
        // Recuperar la publicación
        $recuperoPublicacion = Contenidos::find($data);

        // Obtener el autor y la imagen de perfil
        $autor = $this->usuarioAutor($data, 1);

        // Obtener todas las imágenes asociadas al contenido
        $listaPublicacionConImg = $this->ImagenesContenido($data, 1);

        //Obtengo la actividad
        $actividad = $this->likeDislike($data);

        //Actividad de los comentarios con los comentarios
        $comentarios = $this->comentariosActividad($data);

        // Retornar a la vista
        return view('/content/forum/foroUnico', compact(
            'recuperoPublicacion',
            'listaPublicacionConImg',
            'autor',
            'actividad',
            'comentarios'
        ));
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
            $noticias->imagenes = $this->ImagenesContenido($noticias->idcontenidos, 1);
        }

        return view('/content/news/noticias', compact('recuperoNoticias'));
    }

    #Ver de a uno NOTICIAS
    public function publicacionUnicaNoticias($data)
    {
        // Recuperar la publicación
        $recuperoPublicacion = Contenidos::find($data);

        // Obtener todas las imágenes asociadas al contenido
        $listaPublicacionConImg = $this->ImagenesContenido($data, 1);

        // "Publicidad"

        # Noticias
        $mostrarAparteNoticias = $this->soloCuatroNoticias($data);

        # Eventos
        $mostrarAparteEventos = $this->soloCuatroEventos();

        // Retornar a la vista
        return view('/content/news/noticiaUnica', compact(
            'recuperoPublicacion',
            'listaPublicacionConImg',
            'mostrarAparteNoticias',
            'mostrarAparteEventos'
        ));
    }


    #Apartado solo 4 Noticias
    public function soloCuatroNoticias($data)
    {
        // Ordenar por fechaSubida, descendente pero que no sea la que está abierta
        $recuperoPublicaciones = Contenidos::where('tipoContenido_idtipoContenido', 2)
            ->where('idcontenidos', '!=', $data) // Excluir la publicación actual
            ->orderBy('fechaSubida', 'desc')
            ->take(4)
            ->get();

        // Limitar la descripción a 30 palabras
        foreach ($recuperoPublicaciones as $publicacion) {
            $publicacion->descripcion = Str::words($publicacion->descripcion, 30);
            $publicacion->imagenes = $this->ImagenesContenido($publicacion->idcontenidos, 1); // Almacenar las imágenes
        }

        return $recuperoPublicaciones;
    }


    #Apartado solo 4 Eventos
    public function soloCuatroEventos()
    {
        // Recuperar los últimos 4 shows, ordenados por la fecha del evento de forma descendente
        $recuperoShows = Show::orderBy('fechashow', 'desc')
            ->take(4) // Limitar a 4 resultados
            ->with('lugarLocal') // Cargar la relación 'lugarLocal'
            ->get(); // Ejecutar la consulta y obtener los resultados

        // Crear un array para almacenar los resultados finales
        $resultados = [];

        //Cada show recuperado
        foreach ($recuperoShows as $fly) {
            // Obtener el ID del lugar relacionado con el show
            $idLugar = $fly->lugarLocal_idlugarLocal;

            // Buscar el lugar en la tabla LugarLocal utilizando el ID
            $lugar = LugarLocal::find($idLugar);
            $nombreLugar = $lugar->nombreLugar;

            // Almacenar las imágenes asociadas al contenido del show
            $imagenes = $this->ImagenesContenido($fly->revisionImagenes_idrevisionImagenescol, 2);

            // Crear un nuevo objeto con solo los datos necesarios
            $resultados[] = [
                'fechashow' => $fly->fechashow,
                'imagenes' => $imagenes,
                'nombreLugar' => $nombreLugar,
            ];
        }

        // Retornar los resultados finales
        return $resultados;
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
            $biografia->imagenes = $this->ImagenesContenido($biografia->idcontenidos, 1);
        }

        return view('/content/history/biografia', compact('recuperoRedesSociales', 'recuperoBiografia'));
    }
}

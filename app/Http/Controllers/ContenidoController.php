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
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $idUser = $recuperoPublicacion->Actividad_idActividad;
            $idUser = Actividad::find($idUser);
            $idUser = $idUser->usuarios_idusuarios;

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
        // Recuperar los comentarios relacionados con el contenido específico
        $comentarios = Comentarios::where('contenidos_idcontenidos', $idContent)->get();

        // Array para almacenar la información de cada comentario
        $resultadoComentarios = [];

        // Recorrer cada comentario
        foreach ($comentarios as $comentario) {
            // Recuperar el id de la actividad asociada al comentario
            $idActividad = $comentario->Actividad_idActividad;

            // Obtener la actividad y el id del usuario que realizó el comentario
            $actividad = Actividad::find($idActividad);
            if ($actividad) {
                $idUsuario = $actividad->usuarios_idusuarios; // Asegúrate de que esta relación es correcta

                // Recuperar el autor del comentario
                $autorComentario = $this->usuarioAutor($idUsuario, 2);

                // Recuperar la imagen asociada al comentario
                $idRevisionImg = $comentario->revisionImagenes_idrevisionImagenescol;
                $rutaImagen = $this->ImagenesContenido($idRevisionImg, 2);

                // Formar el array con la información completa del comentario
                $resultadoComentarios[] = [
                    'comentario' => $comentario,             // Detalles del comentario
                    'autor' => $autorComentario['usuario'],   // Información del usuario que comentó
                    'imagenAutor' => $autorComentario['ruta_imagen'], // Imagen de perfil del usuario
                    'imagenComentario' => $rutaImagen         // Imagen asociada al comentario (si existe)
                ];
            }
        }

        // Retornar los comentarios como una colección
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
        // Recupero solo publicaciones Foro
        $recuperoPublicaciones = $this->contenidosReducidos(1);

        // Si no hay publicaciones, inicializo las variables correspondientes
        if ($recuperoPublicaciones->isEmpty()) {
            $recuperoLikes = []; // o null, dependiendo de cómo manejes los likes
            $comentarios = [];    // o null, dependiendo de cómo manejes los comentarios
        } else {
            // Si hay publicaciones, continuo con la lógica
            $recuperoLikes = $this->contadorEstrellasVisual();
            $comentarios = $this->contadorComentarios();
        }

        // Retorno la vista con los datos
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

    #CREAR PUBLICACION (FORO-NOTICIAS)
    public function crearP(Request $request, $type)
    {
        // Validar la entrada
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen.*' => 'nullable|image|max:2048',
        ]);

        // Crear una nueva actividad
        $actividad = new Actividad();
        $actividad->save();

        // Crear nuevo contenido según el tipo
        $contenido = new Contenidos();
        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->tipoContenido_idtipoContenido = $type;
        $contenido->fechaSubida = now();
        $contenido->Actividad_idActividad = $actividad->idActividad;
        $contenido->save();

        // Manejar la carga de las imágenes, si se proporcionan
        if ($request->hasFile('imagen')) {
            foreach ($request->file('imagen') as $imageFile) {
                // Almacenar la imagen en public/storage/img
                $path = $imageFile->store('public/img'); // Guardar en public/storage/img

                // Guardar la ruta correcta en la base de datos
                $imagen = new Imagenes();
                $imagen->subidaImg = 'public/img/' . basename($path); // Solo guardar la ruta relativa
                $imagen->fechaSubidaImg = now();
                $imagen->contenidoDescargable = 'No';
                $imagen->save();

                //Relacionar con RevisionImagenes y con ImagenesContenido

                // Crear relación con revisionImagenes
                $revisionImagen = new RevisionImagenes();
                $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios; // Relacionar con el usuario
                $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
                if ($type == 1) {
                    $revisionImagen->tipodefoto_idtipoDeFoto = 5; // Foro
                } else {
                    $revisionImagen->tipodefoto_idtipoDeFoto = 2; // Noticias o Biografia
                }
                $revisionImagen->save();

                // Relacionar la imagen con el contenido
                $imagenContenido = new ImagenesContenido();
                $imagenContenido->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
                $imagenContenido->contenidos_idcontenidos = $contenido->idcontenidos;
                $imagenContenido->save();
            }
        }

        #Switch primero para separar que tipo de contenido es y redirigir
        switch ($type) {
            case 1:
                #Si es foro
                return redirect()->route('foro')->with('success', 'Publicación creada con éxito.');
                break;
            case 2:
                #Si es noticias
                return redirect()->route('noticias')->with('success', 'Noticia creada con éxito.');
                break;
        }
    }

    #VER FORMULARIO CREAR PUBLICACIONES
    public function verFormularioForo()
    {
        return view('content.forum.foropublicaciones');
    }

    #VER FORMULARIO CREAR PUBLICACIONES
    public function verFormularioNoticia()
    {
        return view('content.news.crearnoticias');
    }
    #MODIFICAR PUBLICACION (FORO-NOTICIAS-BIOGRAFIA)
    public function modificarP(Request $request, $id)
    {
        // Obtener el contenido a editar por ID
        $contenido = Contenidos::findOrFail($id);

        // Validar la entrada
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen.*' => 'nullable|image|max:2048',
        ]);

        // Actualizar el contenido
        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->save(); // Guarda los cambios en el contenido

        // Manejar la carga de las nuevas imágenes, si se proporcionan
        if ($request->hasFile('imagen')) {
            foreach ($request->file('imagen') as $imageFile) {
                // Almacenar la imagen en public/storage/img
                $path = $imageFile->store('public/img'); // Guardar en public/storage/img

                // Guardar la ruta correcta en la base de datos
                $imagen = new Imagenes();
                $imagen->subidaImg = 'public/img/' . basename($path); // Solo guardar la ruta relativa
                $imagen->fechaSubidaImg = now();
                $imagen->contenidoDescargable = 'No';
                $imagen->save();

                // Relacionar con RevisionImagenes y con ImagenesContenido
                $revisionImagen = new RevisionImagenes();
                $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios; // Relacionar con el usuario
                $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;

                // Determinar el tipo de foto
                if ($contenido->tipoContenido_idtipoContenido == 1) {
                    $revisionImagen->tipodefoto_idtipoDeFoto = 5; // Foro
                } else {
                    $revisionImagen->tipodefoto_idtipoDeFoto = 2; // Noticias o Biografía
                }
                $revisionImagen->save();

                // Relacionar la imagen con el contenido
                $imagenContenido = new ImagenesContenido();
                $imagenContenido->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
                $imagenContenido->contenidos_idcontenidos = $contenido->idcontenidos;
                $imagenContenido->save();
            }
        }

        // Redirigir según el tipo de contenido
        switch ($contenido->tipoContenido_idtipoContenido) {
            case 1:
                return redirect()->route('foro')->with('success', 'Publicación actualizada con éxito.');
            case 2:
                return redirect()->route('noticias')->with('success', 'Noticia actualizada con éxito.');
            case 3:
                return redirect()->route('biografia')->with('success', 'Biografía actualizada con éxito.');
        }
    }

    #VER FORMULARIO MODIFICAR PUBLICACIONES(FORO-NOTICIAS-BIOGRAFIA)
    public function editarP($id)
    {
        // Obtener el contenido a editar por ID
        $contenido = Contenidos::findOrFail($id);

        // Obtener las imágenes asociadas
        $imagenes = $contenido->imagenesContenido; // Esta es la relación que debes haber definido en tu modelo

        // Obtener el tipo de contenido
        $tipoContenido = $contenido->tipoContenido_idtipoContenido; // 1: Foro, 2: Noticias, 3: Biografía

        // Redirigir según el tipo de contenido
        switch ($contenido->tipoContenido_idtipoContenido) {
            case 1:
                return view('content.forum.foromodificar', compact('contenido', 'imagenes', 'tipoContenido'));
            case 2:
                return view('content.news.noticiasmodificar', compact('contenido', 'imagenes', 'tipoContenido'));
            case 3:
                return view('content.history.modificarbiografia', compact('contenido', 'imagenes', 'tipoContenido'));
        }
    }

    // Método para eliminar contenido
    public function eliminarContenido($id)
    {
        // Obtener el contenido a eliminar por su ID
        $contenido = Contenidos::findOrFail($id);

        // Obtener el ID de la actividad relacionada
        $actividadId = $contenido->Actividad_idActividad;

        // Obtener todos los comentarios asociados al contenido
        $comentarios = $contenido->comentarios;

        // Eliminar los comentarios asociados
        foreach ($comentarios as $comentario) {
            // Eliminar el comentario
            $comentario->delete();

            // Si el comentario tiene una revisión de imagen asociada
            if ($comentario->revisionImagenes_idrevisionImagenescol) {
                // Obtener la revisión de imagen asociada al comentario
                $revisionImagen = RevisionImagenes::find($comentario->revisionImagenes_idrevisionImagenescol);
                if ($revisionImagen) {
                    // Obtener la imagen asociada a la revisión
                    $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);

                    // Eliminar la revisión de imagen
                    $revisionImagen->delete();

                    // Eliminar la imagen si existe
                    if ($imagen) {
                        $imagen->delete();
                    }
                }
            }
        }

        // Obtener las imágenes de contenido asociadas
        $imagenesContenido = $contenido->imagenesContenido;

        // Eliminar las imágenes de contenido y sus revisiones
        foreach ($imagenesContenido as $imagenContenido) {
            $idReviImg = $imagenContenido->revisionImagenes_idrevisionImagenescol;

            // Primero eliminamos el vínculo de imagenContenido
            $imagenContenido->delete();

            // Verificar si hay revisiones de imagen
            if ($idReviImg) {
                // Obtener la revisión de imagen
                $revisionImagen = RevisionImagenes::find($idReviImg);
                if ($revisionImagen) {
                    // Obtener la imagen asociada
                    $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);

                    // Eliminar la revisión de imagen
                    $revisionImagen->delete();

                    // Eliminar la imagen si existe
                    if ($imagen) {
                        $imagen->delete();
                    }
                }
            }
        }

        // Eliminar el contenido
        $contenido->delete();

        // Obtener la actividad para comprobar si tiene otros contenidos
        $actividad = Actividad::findOrFail($actividadId);

        // Verificar si la actividad tiene otros contenidos antes de eliminarla
        if ($actividad->contenidos()->count() === 0) {
            $actividad->delete(); // Eliminar la actividad si no tiene contenidos relacionados
        }
        // Redirigir según el tipo de contenido
        switch ($contenido->tipoContenido_idtipoContenido) {
            case 1:
                return redirect()->route('foro')->with('success', 'Contenidos con sus respectivos comentarios y imagenes eliminados con éxito.');
            case 2:
                return redirect()->route('noticias')->with('success', 'Contenido de la Noticias y sus imagenes eliminados con éxito.');
        }
    }

    # Crear un nuevo comentario
    public function crearComentario(Request $request, $idContent)
    {
        // Validar los datos
        $request->validate([
            'contenido' => 'nullable|string|max:500|required_without_all:imagen',
            'imagen' => 'nullable|image|max:2048|required_without_all:contenido',
        ]);

        // Crear una nueva actividad
        $actividad = new Actividad();
        $actividad->save();

        // Crear un nuevo comentario
        $comentario = new Comentarios();
        $comentario->fechaComent = now();
        $comentario->descripcion = $request->contenido; // Asegúrate de usar 'contenido'
        $comentario->Actividad_idActividad = $actividad->idActividad; // Asociar la actividad creada
        $comentario->contenidos_idcontenidos = $idContent; // Asociar el contenido específico

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $imagen = new Imagenes();
            $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
            $imagen->subidaImg = $rutaImagen;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            // Crear la revisión de la imagen
            $revisionImagen = new RevisionImagenes();
            $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
            $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
            $revisionImagen->tipodefoto_idtipoDeFoto = 5; // Supongamos que '5' es el tipo de foto para comentarios
            $revisionImagen->save();

            // Asociar la revisión de la imagen al comentario
            $comentario->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        $comentario->save();

        return redirect()->route('foroUnico', ['data' => $idContent])->with('success', 'Comentario agregado exitosamente.');
    }

    #Modificar un comentario especifico
    public function modificarComentario(Request $request, $idComentario)
    {
        // Validar los datos
        $request->validate([
            'contenido' => 'nullable|string|max:500|required_without_all:imagen',
            'imagen' => 'nullable|image|max:2048|required_without_all:contenido',
        ]);

        // Recuperar el comentario existente
        $comentario = Comentarios::find($idComentario);

        if (!$comentario) {
            return redirect()->back()->with('error', 'Comentario no encontrado.');
        }

        // Actualizar el contenido del comentario
        $comentario->descripcion = $request->contenido;

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            // Solo eliminar la imagen anterior si se ha seleccionado una nueva
            if ($comentario->revisionImagenes_idrevisionImagenescol) {
                $revisionImagen = RevisionImagenes::find($comentario->revisionImagenes_idrevisionImagenescol);
                if ($revisionImagen && $revisionImagen->imagenes) { // Verifica que la imagen exista
                    // Eliminar la imagen antigua
                    Storage::disk('public')->delete($revisionImagen->imagenes->subidaImg);
                    $revisionImagen->delete(); // También eliminar la revisión de imagen si es necesario
                }
            }

            // Guardar la nueva imagen
            $imagen = new Imagenes();
            $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
            $imagen->subidaImg = $rutaImagen;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            // Crear la revisión de la nueva imagen
            $revisionImagen = new RevisionImagenes();
            $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
            $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
            $revisionImagen->tipodefoto_idtipoDeFoto = 5; // Supongamos que '5' es el tipo de foto para comentarios
            $revisionImagen->save();

            // Asociar la nueva revisión de la imagen al comentario
            $comentario->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        // Si no se subió una nueva imagen, se mantendrá la imagen existente

        $comentario->save();

        return redirect()->route('foroUnico', ['data' => $comentario->contenidos_idcontenidos])->with('success', 'Comentario modificado exitosamente.');
    }

    #Eliminar Comentario
    public function eliminarComentario($idComentario)
    {
        // Recuperar el comentario existente
        $comentario = Comentarios::find($idComentario);

        if (!$comentario) {
            return redirect()->back()->with('error', 'Comentario no encontrado.');
        }

        // Almacenar la id de la actividad relacionada
        $actividadId = $comentario->Actividad_idActividad;

        // Manejo de la imagen y revisión de imagen
        $revisionImagenId = $comentario->revisionImagenes_idrevisionImagenescol;

        // Eliminar el comentario
        $comentario->delete();

        // Eliminar la actividad relacionada si existe
        if ($actividadId) {
            $actividad = Actividad::find($actividadId);
            if ($actividad) {
                $actividad->delete();
            }
        }

        // Eliminar la revisión de imagen y la imagen asociada
        if ($revisionImagenId) {
            $revisionImagen = RevisionImagenes::find($revisionImagenId);
            if ($revisionImagen) {
                // Eliminar la revisión de la imagen
                $revisionImagen->delete();

                // Eliminar la imagen asociada
                if ($revisionImagen->imagenes_idimagenes) {
                    $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);

                    if ($imagen) {
                        // Eliminar la imagen del almacenamiento
                        Storage::disk('public')->delete($imagen->subidaImg);
                        // Eliminar la imagen de la base de datos
                        $imagen->delete();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Comentario eliminado exitosamente.');
    }
}

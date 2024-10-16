<?php

namespace App\Http\Controllers;

#CLASES
use App\Models\Actividad;
use App\Models\Comentarios;
use App\Models\Contenidos;
use App\Models\Imagenes;
use App\Models\Interacciones;
use App\Models\ImagenesContenido;
use App\Models\LugarLocal;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use App\Models\Usuario;
use App\Models\Reportes;

use App\Mail\msjReporto;
use App\Mail\msjReportaron;

#OTROS
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Switch_;
use Illuminate\Support\Facades\DB;

class ContenidoController extends Controller
{
    public $links;

    #Recupero las redes y muestro en la vista
    public function linksRedes()
    {
        return $this->links = RedesSociales::whereRaw('nombreRedSocial NOT REGEXP "^[0-9]"')->get();
    }

    // Función para obtener la ruta de las imágenes a partir de la revisión de imágenes
    public function RevImagen($revisionImagenes)
    {
        $rutasImg = []; // Inicializo el array para almacenar las rutas

        if ($revisionImagenes) {
            // Obtengo el ID de la imagen
            $idImagen = $revisionImagenes->imagenes_idimagenes;

            // Busco la imagen en la tabla de imágenes
            $imagen = Imagenes::where('idimagenes', $idImagen)->first();

            if ($imagen) {
                // Obtengo la ruta de la imagen
                $rutaImg = $imagen->subidaImg;

                // Almaceno la ruta en el array
                $rutasImg[] = $rutaImg;
            }
        }

        return $rutasImg; // Devuelvo el array de rutas
    }

    // Función para obtener las imágenes de contenido
    public function ImagenesContenido($idContent, $opcion)
    {
        $rutasImg = []; // Array para almacenar las rutas de las imágenes

        if ($opcion == 1) {
            // Recupero todas las imágenes que coincidan con el idContenido
            $imagenes = ImagenesContenido::where('contenidos_idcontenidos', $idContent)->get();

            foreach ($imagenes as $imgEspecifica) {
                // Obtengo el id de revisión de imágenes
                $idRevImg = $imgEspecifica->revisionImagenes_idrevisionImagenescol;

                // Busco la revisión de imágenes
                $revisionImagenes = RevisionImagenes::where('idrevisionImagenescol', $idRevImg)->first();

                // Si existe la revisión de imágenes, llamo a RevImagen
                if ($revisionImagenes) {
                    $rutasImg = array_merge($rutasImg, $this->RevImagen($revisionImagenes));
                }
            }
        } elseif ($opcion == 2) {
            // Recupero la imagen que coincida con el id de la tabla revisión imágenes
            $revisionImagenes = RevisionImagenes::find($idContent);

            // Llamo a la función RevImagen
            $rutasImg = $this->RevImagen($revisionImagenes);
        }

        // Devuelvo las rutas de las imágenes
        return $rutasImg;
    }

    #OBTENGO PUBLICACIONES DEL 1 FORO - 2 NOTICIAS
    public function getPublicaciones($dato)
    {
        // Ordenar por fechaSubida, descendente
        $recuperoPublicaciones = Contenidos::where('tipoContenido_idtipoContenido', $dato)->orderBy('fechaSubida', 'desc')->get();
        return $recuperoPublicaciones;
    }

    ## BIOGRAFIA
    # ENVIO A LA VISTA LA PUBLICACION DE BIOGRAFIA
    public function indexBiografia()
    {
        #Envio RedesSociales
        $recuperoRedesSociales = $this->linksRedes();
        # Recupero solo publicaciones de Biografia
        $recuperoBiografia = Contenidos::where('tipoContenido_idtipoContenido', 3)->first();

        $idBio = $recuperoBiografia->idcontenidos;

        // Recupero todas las imágenes que tengan ese idcontenidos
        $imagenesBiografia = ImagenesContenido::with('revisionImagenes.imagenes')
            ->where('contenidos_idcontenidos', $idBio)
            ->get();

        return view('/content/history/biografia', compact('recuperoRedesSociales', 'recuperoBiografia', 'imagenesBiografia'));
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
                $path = $imageFile->store('img', 'public'); // Guardar en public/storage/img

                // Guardar la ruta correcta en la base de datos
                $imagen = new Imagenes();
                $imagen->subidaImg = $path; // Solo guardar la ruta relativa
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
                return redirect()->route('foro')->with('alertPublicacion', [
                    'type' => 'Success',
                    'message' => 'Publicación actualizada con éxito.',
                ]);
            case 2:
                return redirect()->route('noticias')->with('alertNoticia', [
                    'type' => 'Success',
                    'message' => 'Noticia actualizada con éxito.',
                ]);
            case 3:
                return redirect()->route('biografia')->with('alertBiografia', [
                    'type' => 'Success',
                    'message' => 'Biografia actualizada con éxito.',
                ]);
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

    #DESCRIPCION REDUCIDA
    public function contenidosReducidos($dato, $orden = 'desc')
    {
        // Ordenar por fechaSubida de forma descendente o ascendente según el parámetro
        return Contenidos::where('tipoContenido_idtipoContenido', $dato)
            ->orderBy('fechaSubida', $orden)
            ->get()
            ->map(function ($publicacion) {
                // Reducir la descripción a 30 palabras
                $publicacion->descripcion = Str::words($publicacion->descripcion, 30);
                return $publicacion;
            });
    }

    #ORDENAR PARA EL INDEX NOTICIAS Y FORO
    public function ordenarNF($tipoContenido, $tipo)
    {
        switch ($tipo) {
            case 1: // Más reciente
                return $this->contenidosReducidos($tipoContenido, 'desc');

            case 2: // Más antiguo
                return $this->contenidosReducidos($tipoContenido, 'asc');

            case 3: // Mayor número de interacciones (punteo)
                return Contenidos::where('tipoContenido_idtipoContenido', $tipoContenido)
                    ->leftJoin('interacciones', 'contenidos.actividad_idActividad', '=', 'interacciones.actividad_idActividad')
                    ->select(
                        'contenidos.*',
                        DB::raw('COALESCE(SUM(interacciones.megusta + interacciones.nomegusta), 0) as totalInteracciones')
                    )
                    ->groupBy('contenidos.idcontenidos') // Agrupar por ID del contenido
                    ->orderByDesc('totalInteracciones') // Ordenar por interacciones
                    ->get()
                    ->each(function ($contenido) {
                        $contenido->descripcion = Str::words($contenido->descripcion, 30); // Reducir descripción
                    });

            default: // Orden por defecto (más reciente)
                return $this->contenidosReducidos($tipoContenido, 'desc');
        }
    }

    ## NOTICIAS
    # ENVIO A LA VISTA LAS PUBLICACIONES DE LAS NOTICIAS
    public function indexNoticias(Request $request)
    {
        // Recupero el tipo de orden si es que fue enviado por la vista (1: más reciente, 2: más antiguo, 3: más interacciones)
        $orden = $request->query('orden', 1); // Valor por defecto: 1 (más reciente)

        // Recupero solo publicaciones de Noticias y las ordeno según el parámetro
        $recuperoNoticias = $this->ordenarNF(2, $orden); // Tipo de contenido 2 para Noticias

        // Recorro las publicaciones para obtener las imágenes asociadas
        foreach ($recuperoNoticias as $noticias) {
            $noticias->imagenes = $this->ImagenesContenido($noticias->idcontenidos, 1);
        }

        return view('/content/news/noticias', compact('recuperoNoticias'));
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

    #Apartado solo 2 Eventos
    public function soloDosEventos()
    {
        // Recuperar los últimos 4 shows, ordenados por la fecha del evento de forma descendente
        $recuperoShows = Show::orderBy('fechashow', 'desc')
            ->take(2) // Limitar a 4 resultados
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
        $mostrarAparteEventos = $this->soloDosEventos();

        // Retornar a la vista
        return view('/content/news/noticiaUnica', compact(
            'recuperoPublicacion',
            'listaPublicacionConImg',
            'mostrarAparteNoticias',
            'mostrarAparteEventos'
        ));
    }

    # ContarComentarios
    public function contadorComentarios($recuperoPublicaciones)
    {
        // Inicializo un array para almacenar la cantidad de comentarios por publicación
        $contarComentarios = [];

        // Recorro las publicaciones para obtener el número de comentarios
        foreach ($recuperoPublicaciones as $publicacion) {
            // Recupero y cuento los comentarios asociados a la publicación
            $contadorComentarios = Comentarios::where('contenidos_idcontenidos', $publicacion->idcontenidos)->count();

            // Almaceno el conteo en el array
            $contarComentarios[$publicacion->idcontenidos] = [
                'cuenta' => $contadorComentarios,
            ];
        }
        return $contarComentarios;
    }

    # ContarInteracciones
    public function contadorInteracciones($recuperoPublicaciones)
    {
        // Inicializo un array para almacenar la cantidad de interacciones por publicación
        $contarInteracciones = [];

        // Recorro las publicaciones para obtener el número de interacciones (Likes, dislikes y reportes)
        foreach ($recuperoPublicaciones as $publicacion) {
            // Recupero las interacciones asociadas a la publicación
            $interacciones = Interacciones::where('Actividad_idActividad', $publicacion->Actividad_idActividad)
                ->select('megusta', 'nomegusta')
                ->get();

            // Almaceno los likes, dislikes y reportes en el array
            $contarInteracciones[$publicacion->idcontenidos] = [
                'megusta' => $interacciones->sum('megusta'),
                'nomegusta' => $interacciones->sum('nomegusta'),
            ];
        }
        return $contarInteracciones;
    }

    #Visualmente Puntuacion de Foro
    public function contadorEstrellasVisual($recuperoLikes)
    {
        # Arreglo para almacenar la visualización de las estrellas
        $estrellasVisuales = [];

        # Recorro las publicaciones
        foreach ($recuperoLikes as $idPublicacion => $data) {
            # Recupero la cantidad de likes y dislikes
            $datoLike = $data['megusta'];
            $datoDislike = $data['nomegusta'];

            # Calculo la puntuación total
            $total = $datoLike + $datoDislike;

            # Datos de las estrellas
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
                'dislike' => $datoDislike,
            ];
        }
        return $estrellasVisuales;
    }

    ## FORO
    # ENVIO A LA VISTA LAS PUBLICACIONES DEL FORO
    public function indexForo(Request $request)
    {
        // Verifico si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('superFan')->with('alertRegistro', [
                'type' => 'Warning',
                'message' => 'Solo los usuarios registrados pueden acceder al foro.',
            ]);
        }

        // Recupero el tipo de orden si es que fue enviado por la vista (1: más reciente, 2: más antiguo, 3: más interacciones)
        $orden = $request->query('orden', 1); // Valor por defecto: 1 (más reciente)

        // Recupero solo publicaciones del foro y las ordeno según el parámetro
        $recuperoPublicaciones = $this->ordenarNF(1, $orden); // Tipo de contenido 1 para Foro

        // Recupero los comentarios y las interacciones (likes y dislikes)
        $contadorComentarios = $this->contadorComentarios($recuperoPublicaciones);
        $recuperoLikes = $this->contadorInteracciones($recuperoPublicaciones);
        $recuperoLikes = $this->contadorEstrellasVisual($recuperoLikes); // Mostrar Estrellas

        // Envío los datos necesarios a la vista
        return view('/content/forum/foro', compact('recuperoPublicaciones', 'recuperoLikes', 'contadorComentarios'));
    }

    #Solo imagen
    public function fImagen($idUser)
    {
        // Obtenemos la información completa del autor
        $autor = Usuario::where('idusuarios', $idUser)->first();

        // Obtenemos la imagen de perfil del usuario (tipo de foto 1)
        $imagenUsuarioPerfil = RevisionImagenes::where('usuarios_idusuarios', $idUser)
            ->where('tipodefoto_idtipoDeFoto', 1)
            ->first();

        // Si existe la imagen de perfil asociada, obtenemos la ruta
        $rutaImg = null;
        if ($imagenUsuarioPerfil) {
            $imagenPerfil = Imagenes::where('idimagenes', $imagenUsuarioPerfil->imagenes_idimagenes)->first();
            $rutaImg = $imagenPerfil ? $imagenPerfil->subidaImg : null;
        }

        // Devolvemos el usuario junto con la ruta de su imagen
        return [
            'usuario' => $autor,
            'ruta_imagen' => $rutaImg
        ];
    }

    #Recupero el Perfil Usuario
    public function usuarioAutor($idContent, $opcion)
    {
        if ($opcion == 1) {
            // Recuperamos la publicación por su ID
            $recuperoPublicacion = Contenidos::find($idContent);

            // Obtenemos el ID del usuario asociado a la publicación
            $idUser = Actividad::find($recuperoPublicacion->Actividad_idActividad)->usuarios_idusuarios;

            #Llamo a la funcio imagen
            $perfil = $this->fImagen($idUser);

            return $perfil;
        } elseif ($opcion == 2) {
            #Llamo a la funcio imagen
            $perfil = $this->fImagen($idContent);

            return $perfil;
        }
    }

    # Obtener los comentarios de la actividad
    public function obtenerComentarios($idContent)
    {
        // Recuperar los comentarios relacionados con el contenido específico
        $comentarios = Comentarios::where('contenidos_idcontenidos', $idContent)
            ->orderBy('fechaComent', 'desc')
            ->get();

        // Array para almacenar la información de cada comentario
        $resultadoComentarios = [];

        // Obtener el ID del usuario autenticado
        $idUsuarioAuth = Auth::user()->idusuarios;

        // Recorrer cada comentario
        foreach ($comentarios as $comentario) {
            // Recuperar el id de la actividad asociada al comentario
            $actividad = Actividad::find($comentario->Actividad_idActividad);

            if ($actividad) {
                $idUsuario = $actividad->usuarios_idusuarios;

                // Recuperar el autor del comentario
                $autorComentario = $this->usuarioAutor($idUsuario, 2);

                // Recuperar la imagen asociada al comentario
                $rutaImagen = $this->ImagenesContenido($comentario->revisionImagenes_idrevisionImagenescol, 2);

                // Recuperar like y dislike del comentario específico
                $likeDislike = $this->likeDislike($comentario->Actividad_idActividad, 2);

                // Recuperar la interacción del usuario autenticado en este comentario
                $interaccionUsuario = Interacciones::where('actividad_idActividad', $comentario->Actividad_idActividad)
                    ->where('usuarios_idusuarios', $idUsuarioAuth)
                    ->first();

                // Formar el array con la información completa del comentario
                $resultadoComentarios[] = [
                    'comentario' => $comentario,
                    'autor' => $autorComentario['usuario'],
                    'imagenAutor' => $autorComentario['ruta_imagen'],
                    'imagenComentario' => $rutaImagen,
                    'interaccionComentario' => $likeDislike,
                    'interaccionUsuario' => $interaccionUsuario, // Agregamos aquí la interacción
                ];
            }
        }

        // Retornar los comentarios como una colección
        return collect($resultadoComentarios);
    }

    # Función para obtener likes y dislikes de una publicación
    public function likeDislikeGeneral($idContent)
    {
        // Obtener las interacciones relacionadas con la actividad
        $respuestas = Interacciones::where('Actividad_idActividad', $idContent)
            ->select('megusta', 'nomegusta', 'reporte')
            ->get();

        // Almacenar los likes, dislikes y reportes en el array
        return [
            'megusta' => $respuestas->sum('megusta'),
            'nomegusta' => $respuestas->sum('nomegusta'),
            'reporte' => $respuestas->sum('reporte'),
        ];
    }

    # Obtener likes y dislikes de una publicación específica
    public function likeDislike($idContent, $option)
    {
        if ($option == 1) {
            $recuperoPublicacion = Contenidos::find($idContent);
            $idContent = $recuperoPublicacion->Actividad_idActividad; // Usar el ID de actividad
        }

        return $this->likeDislikeGeneral($idContent);
    }

    // Recuperar publicación única para el foro
    public function publicacionUnicaForo($data)
    {
        // Recuperar la publicación
        $recuperoPublicacion = Contenidos::find($data);
        $idActividad = $recuperoPublicacion->Actividad_idActividad;

        // Imagen del usuario autenticado
        $imagen = $this->usuarioAutor(Auth::user()->idusuarios, 2);

        // Autor de la publicación y su imagen de perfil
        $autor = $this->usuarioAutor($data, 1);

        // Todas las imágenes asociadas al contenido
        $listaPublicacionConImg = $this->ImagenesContenido($data, 1);

        // Total de actividad (likes y dislikes)
        $actividad = $this->likeDislike($data, 1);

        // Recuperar la interacción del usuario autenticado
        $interaccionUsuario = Interacciones::where('actividad_idActividad', $idActividad)
            ->where('usuarios_idusuarios', Auth::user()->idusuarios)
            ->first();

        // Obtener comentarios
        $comentarios = $this->obtenerComentarios($data);

        // Retornar a la vista con los datos necesarios
        return view('content.forum.foroUnico', compact(
            'recuperoPublicacion',
            'listaPublicacionConImg',
            'autor',
            'actividad',
            'comentarios',
            'imagen',
            'interaccionUsuario'
        ));
    }

    #Eliminar Revision e Imagenes
    private function eliminarImagenYRevision($revisionImagenId)
    {
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
    }

    // Método para eliminar contenido
    public function eliminarContenido($id)
    {
        // Obtener el contenido a eliminar por su ID
        $contenido = Contenidos::findOrFail($id);

        // Obtener el ID de la actividad relacionada
        $actividadId = $contenido->Actividad_idActividad;

        // Eliminar las interacciones del contenido
        Interacciones::where('Actividad_idActividad', $actividadId)->delete();

        // Eliminar los comentarios asociados
        foreach ($contenido->comentarios as $comentario) {
            // Eliminar las interacciones del comentario
            Interacciones::where('Actividad_idActividad', $comentario->Actividad_idActividad)->delete();

            // Eliminar el comentario
            $comentario->delete();

            // Eliminar la imagen asociada al comentario
            $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);

            // Eliminar la actividad del comentario de la tabla actividad
            Actividad::where('idActividad', $comentario->Actividad_idActividad)->delete();
        }

        // Eliminar las imágenes de contenido y sus revisiones
        foreach ($contenido->imagenesContenido as $imagenContenido) {
            // Eliminar la imagen de contenido
            $imagenContenido->delete();

            // Eliminar la revisión de imagen asociada
            $this->eliminarImagenYRevision($imagenContenido->revisionImagenes_idrevisionImagenescol);
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
                return redirect()->route('foro')->with('alertForo', [
                    'type' => 'Success',
                    'message' => 'Contenido del Foto con sus respecticos comentarios e imágenes eliminados con éxito.',
                ]);
            case 2:
                return redirect()->route('noticias')->with('alertNoticia', [
                    'type' => 'Success',
                    'message' => 'Contenido de la Noticias y sus imágenes eliminados con éxito.',
                ]);
        }
    }

    #Eliminar Comentario
    public function eliminarComentario($idComentario)
    {
        // Recuperar el comentario existente
        $comentario = Comentarios::find($idComentario);

        // Eliminar las interacciones del comentario
        Interacciones::where('Actividad_idActividad', $comentario->Actividad_idActividad)->delete();

        // Eliminar el comentario
        $comentario->delete();

        // Eliminar la imagen y la revisión asociada
        $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);

        return redirect()->back()->with('alertPublicacion', [
            'type' => 'Success',
            'message' => 'Comentario eliminado exitosamente.',
        ]);
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

    // Método para manejar la carga de la imagen y su revisión
    private function manejarImagenYRevision($imagenFile, $tipoFoto)
    {
        // Asignar el tipo de foto según el valor proporcionado
        if ($tipoFoto == 1 || $tipoFoto == 5) {
            $tipoFoto = 5;
        } elseif ($tipoFoto == 2) {
            $tipoFoto = 2;
        }
        $imagen = new Imagenes();
        $rutaImagen = $imagenFile->store('img', 'public');
        $imagen->subidaImg = $rutaImagen;
        $imagen->fechaSubidaImg = now();
        $imagen->contenidoDescargable = 'No';
        $imagen->save();

        // Crear la revisión de la imagen
        $revisionImagen = new RevisionImagenes();
        $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
        $revisionImagen->tipodefoto_idtipoDeFoto = $tipoFoto;
        $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
        $revisionImagen->save();

        // Retorna tanto la imagen como la revisión
        return [$imagen, $revisionImagen];
    }

    #Crea actividad
    private function crearActividad($tipo)
    {
        $actividad = new Actividad();
        $actividad->tipoActividad_idtipoActividad = $tipo;
        $actividad->save();
        return $actividad;
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
        $actividad = $this->crearActividad(3);

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
                list($imagen, $revisionImagen) = $this->manejarImagenYRevision($imageFile, $type);

                // Relacionar con ImagenesContenido
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
                return redirect()->route('foro')->with('alertForo', [
                    'type' => 'Success',
                    'message' => 'Publicacion creada con éxito.',
                ]);
                break;
            case 2:
                #Si es noticias
                return redirect()->route('noticias')->with('alertNoticia', [
                    'type' => 'Success',
                    'message' => 'Noticia creada con éxito.',
                ]);
                break;
        }
    }

    public function crearComentario(Request $request, $idContent)
    {
        // Validar los datos: al menos un campo debe estar presente (contenido o imagen)
        $request->validate([
            'contenido' => 'nullable|string|max:500|required_without_all:imagen',
            'imagen' => 'nullable|image|max:2048|required_without_all:contenido',
        ]);

        // Crear una nueva actividad
        $actividad = $this->crearActividad(2);

        // Crear un nuevo comentario
        $comentario = new Comentarios();
        $comentario->fechaComent = now();
        $comentario->descripcion = $request->contenido ?? ''; // Si no hay contenido, guarda cadena vacía
        $comentario->Actividad_idActividad = $actividad->idActividad;
        $comentario->contenidos_idcontenidos = $idContent;

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            // Llamar a la función que maneja la imagen y la revisión
            list($imagen, $revisionImagen) = $this->manejarImagenYRevision($request->file('imagen'), 5);

            // Asociar la imagen con el comentario
            $comentario->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        // Guardar el comentario
        $comentario->save();

        return redirect()->route('foroUnico', ['data' => $idContent])->with('alertPublicacion', [
            'type' => 'Success',
            'message' => 'Comentario agregado exitosamente.',
        ]);
    }

    #Modificar un comentario especifico
    public function modificarComentario(Request $request, $idComentario)
    {
        // Validar los datos
        $request->validate([
            'contenido' => 'nullable|string|max:500|',
            'imagen' => 'nullable|image|max:2048|',
        ]);

        // Recuperar el comentario existente
        $comentario = Comentarios::find($idComentario);

        // Verificar si el comentario existe
        if (!$comentario) {
            return redirect()->back()->with('alertPublicacion', [
                'type' => 'Error',
                'message' => 'El comentario no fue encontrado.',
            ]);
        }

        // Actualizar el contenido del comentario solo si se proporciona
        if ($request->filled('contenido')) {
            $comentario->descripcion = $request->contenido;
        }

        // Manejo de eliminación de la imagen
        if ($request->input('imagen_eliminada') == 1) {
            // Si hay una imagen asociada, eliminarla
            if ($comentario->revisionImagenes_idrevisionImagenescol) {
                // Desvincular la imagen del comentario y guardar el cambio antes de eliminar la imagen
                $revisionImagenId = $comentario->revisionImagenes_idrevisionImagenescol;
                $comentario->revisionImagenes_idrevisionImagenescol = null;
                $comentario->save(); // Guardar antes de proceder a la eliminación

                // Ahora que el comentario ya no está vinculado a la imagen, eliminar la revisión
                $this->eliminarImagenYRevision($revisionImagenId);
            }
        }

        if (!$request->contenido &&  !$request->hasFile('imagen')) {
            // Eliminar  el comentario si no se proporciona contenido ni imagen
            $comentario->delete();
            return redirect()->back()->with('alertPublicacion', [
                'type' => 'Success',
                'message' => 'Comentario eliminado exitosamente.',
            ]);
        }

        // Manejo de nueva imagen subida
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si ya existía una asociada
            if ($comentario->revisionImagenes_idrevisionImagenescol) {
                $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
            }

            list($imagen, $revisionImagen) = $this->manejarImagenYRevision($request->file('imagen'), 5);

            // Asociar la nueva revisión de la imagen al comentario
            $comentario->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        // Guardar solo si hubo algún cambio
        if ($comentario->isDirty()) {
            $comentario->save();
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('foroUnico', ['data' => $comentario->contenidos_idcontenidos])->with('alertPublicacion', [
            'type' => 'Success',
            'message' => 'Comentario modificado exitosamente.',
        ]);
    }

    #Para reporte cuando toque el boton debe de hacer el pasaje a la tabla de reportes (Pueden reportar en forounico tanto comentarios como la misma publicacion.)
    public function reportarActividadEspecifica($id)
    {
        #Recupero quien es el usuario que reporto
        $usuarioReporte = Auth::user();

        // Recuperar la interacción existente
        $interaccion = Interacciones::where('actividad_idActividad', $id)
            ->where('usuarios_idusuarios', $usuarioReporte->idusuarios)
            ->first();

        // Crear nueva interacción si no existe
        if (!$interaccion) {
            $interaccion = new Interacciones();
            $interaccion->usuarios_idusuarios = $usuarioReporte->idusuarios;
            $interaccion->actividad_idActividad = $id;
        } else {
            return redirect()->back()->with('alertPublicacion', [
                'type' => 'Warning',
                'message' => 'Ya has reportado esta actividad.',
            ]);
        }

        // Actualizar la interacción de repote
        $interaccion->reporte = 1;

        // Guardar la interacción
        $interaccion->save();

        // Recupero que actividad reporto
        $actividad = Actividad::find($id);

        // Recupero el usuario que fue reportado (Creo la publicacion)
        $usuarioReportado = $actividad->usuarios_idusuarios;

        $usuarioReportado = Usuario::find($usuarioReportado);

        // Crear Reporte
        $reporte = new Reportes();
        $reporte->usuarios_idusuarios = $usuarioReportado->idusuarios;

        #Envia mails ...

        #1 Reportaste la cuenta...
        Mail::to($usuarioReporte->correoElectronicoUser)->send(new msjReporto($usuarioReportado->genero, $usuarioReportado->usuarioUser, $actividad->tipoActividad_idtipoActividad));

        #2 Admin Reporto x a y, revisar publicacion...
        Mail::to($usuarioReporte->correoElectronicoUser)->send(new msjReportaron($usuarioReporte->usuarioUser, $usuarioReporte->genero, $usuarioReportado->usuarioUser, $actividad->tipoActividad_idtipoActividad));

        return redirect()->back()->with('alertPublicacion', [
            'type' => 'Success',
            'message' => 'Actividad reportada exitosamente.',
        ]);
    }

    public function likeDislikeActividad($tipo, $id)
    {
        $userId = Auth::user()->idusuarios;

        // Recuperar la interacción existente
        $interaccion = Interacciones::where('actividad_idActividad', $id)
            ->where('usuarios_idusuarios', $userId)
            ->first();

        // Crear nueva interacción si no existe
        if (!$interaccion) {
            $interaccion = new Interacciones();
            $interaccion->usuarios_idusuarios = $userId;
            $interaccion->actividad_idActividad = $id;
        }

        // Actualizar la interacción según el tipo
        if ($tipo === 'Like' && $interaccion->megusta === 1) {
            $interaccion->megusta = 0;
        } elseif ($tipo === 'Dislike' && $interaccion->nomegusta === 1) {
            $interaccion->nomegusta = 0;
        } else {
            $interaccion->megusta = $tipo === 'Like' ? 1 : 0;
            $interaccion->nomegusta = $tipo === 'Dislike' ? 1 : 0;
        }

        // Guardar la interacción
        $interaccion->save();

        // Si la interaccion tiene 0 me gustas y 0 no me gustas se elimina
        if ($interaccion->megusta === 0 && $interaccion->nomegusta === 0 && $interaccion->reporte === 0) {
            $interaccion->delete();
        }

        return redirect()->back();
    }
}

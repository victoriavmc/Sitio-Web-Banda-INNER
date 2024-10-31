<?php

namespace App\Http\Controllers;

use App\Models\AlbumDatos;
use App\Models\AlbumImagenes;
use App\Models\AlbumMusical;
use App\Models\AlbumVideo;
use App\Models\Cancion;
use App\Models\Imagenes;
use App\Models\Notificaciones;
use App\Models\RevisionImagenes;
use App\Models\TipoNotificacion;
use App\Models\Usuario;
use App\Models\Videos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Mail\msjNotificaciones;
use Illuminate\Support\Facades\Mail;

class AlbumController extends Controller
{
    //Cada que se cree algun album nuevo debe enviar notificacion al usuario que marco el tiponotificacion especifico
    public function creadoAlbumNotificar($tipoNotificacion, $titulo)
    {
        // Recuperar las notificaciones según el tipo
        $notificados = Notificaciones::where('tipoNotificación_idtipoNotificación', $tipoNotificacion)->get();

        $nombreDescripcion = TipoNotificacion::find($tipoNotificacion)->nombreNotificacion;

        foreach ($notificados as $noti) {
            $usuariosNotificar = $noti->usuarios_idusuarios;
            $maildeusuario = Usuario::find($usuariosNotificar);

            // Verificar que el usuario exista antes de intentar acceder a su correo
            if ($maildeusuario) {
                $correo = $maildeusuario->correoElectronicoUser;

                // Lógica para enviar el correo según el tipo de notificación
                switch ($tipoNotificacion) {
                    case 4:
                        // Lógica específica para álbum de imagen o video
                        // $titulo; paso el titulo
                        $msj = 'Se ha creado un nuevo album de imagen o video titulado: ' . $titulo;
                        Mail::to($correo)->send(new msjNotificaciones($nombreDescripcion, $msj));
                        break;

                    case 5:
                        // Lógica específica para álbum musical
                        // $titulo; paso el titulo
                        $msj = 'Se ha creado un nuevo álbum musical: ' . $titulo;
                        Mail::to($correo)->send(new msjNotificaciones($nombreDescripcion, $msj));
                        break;
                }
            }
        }
    }

    public function manejarAlbum(Request $request)
    {
        $accion = (int) $request->accion;
        $tipoAlbum = (int) $request->tipoAlbum;

        $idAlbumEspecifico = null;
        $imagen = null;
        $video = null;

        $titulo = '';
        switch ($tipoAlbum) {
            case 1:
                $titulo = 'Música';
                break;
            case 2:
                $titulo = 'Videos';
                break;
            case 3:
                $titulo = 'Imágenes';
                break;
        }


        switch ($accion) {
            case 1:
                return view('components.manejo-album', compact('accion', 'tipoAlbum', 'titulo', 'imagen', 'video'));
                break;

            case 2:

                $idAlbumEspecifico = (int) $request->idAlbumEspecifico;

                $album = AlbumDatos::find($idAlbumEspecifico);

                if ($album) {
                    $tituloAlbum = $album->tituloAlbum;
                    $fechaSubida = $album->fechaSubido;

                    switch ($tipoAlbum) {

                        case 1:

                            $albumMusical = AlbumMusical::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();

                            if ($albumMusical) {
                                $revisionImagen = $albumMusical->revisionimagenes ?? null;
                                $imagen = $revisionImagen ? $revisionImagen->imagenes->subidaImg : 'logo_inner.webp';
                            }
                            break;

                        case 2:

                            $albumVideo = AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();

                            if ($albumVideo) {
                                $videoDetails = Videos::find($albumVideo->videos_idvideos);
                                if ($videoDetails) {
                                    $video = $videoDetails->subidaVideo;
                                }
                            }
                            break;

                        case 3:

                            $albumImagenes = AlbumImagenes::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                            // Obtener la información de las imágenes asociadas al álbum
                            if ($albumImagenes) {
                                $revisionImagen = $albumImagenes->revisionimagenes ?? null;
                                $imagen = $revisionImagen ? $revisionImagen->imagenes->subidaImg : 'logo_inner.webp';
                            }
                            break;
                    }
                    return view('components.manejo-album', compact('accion', 'tipoAlbum', 'tituloAlbum', 'titulo', 'idAlbumEspecifico', 'fechaSubida', 'imagen', 'video'));
                }

                break;
        }
    }

    public function rules($tipoAlbum)
    {
        // Inicializa el arreglo de reglas
        $rules = [
            'titulo' => 'required|string|max:255',
            'fecha' => 'required|date',
        ];

        // Agrega reglas dependiendo del tipo de álbum
        if ($tipoAlbum == 1) {
            // Álbum de tipo 1: solo una imagen
            $rules['imagen'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        } elseif ($tipoAlbum == 2) {
            // Álbum de tipo 2: solo un video
            $rules['video'] = 'required|file|mimes:mp4,mov,avi,mkv|max:20480';
        } elseif ($tipoAlbum == 3) {
            // Álbum de tipo 3: solo una imagen
            $rules['imagen'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        } elseif ($tipoAlbum == 4) {
            $rules['video'] = 'nullable|file|mimes:mp4,mov,avi,mkv|max:20480';
        }

        return $rules;
    }

    #GUARDO IMAGEN
    public function guardarImagenSiExiste($imagen, $tipo)
    {
        if ($imagen && $imagen->isValid()) {

            // Crear una instancia de ImageManager
            $manager = new ImageManager(new Driver());

            // Crear la ruta de almacenamiento de la imagen y el nombre del archivo
            $filename = uniqid() . '.webp';
            $path = public_path('storage/img/' . $filename);

            // Guardar la imagen en el almacenamiento
            $imgSubida = $manager->read($imagen);

            // Convertir la imagen a formato webp y redimensionarla
            $imgSubida->toWebp(75)->save($path);

            $imagenModel = new Imagenes();
            $imagenModel->subidaImg = 'img/' . $filename;
            $imagenModel->fechaSubidaImg = now();
            $imagenModel->save();
            $revImg = new RevisionImagenes();
            $revImg->usuarios_idusuarios = Auth::user()->idusuarios;
            $revImg->imagenes_idimagenes = $imagenModel->idimagenes;
            if ($tipo == 1) {
                $revImg->tipodefoto_idtipodefoto = 6;
            } else {
                $revImg->tipodefoto_idtipodefoto = 3;
            }
            $revImg->save();

            return $revImg;
        }
        return null;
    }

    /// INICIO
    public function manejoAlbum(Request $request, $accion, $tipoAlbum)
    {
        // Valida los datos
        $validator = Validator::make($request->all(), $this->rules($tipoAlbum));

        // Verifica si la validación falló
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertAlbum', [
                'type' => 'Warning',
                'message' => 'Error al cargar datos.',
            ]);
        }

        if ($accion == '1') {

            // Crea Album
            $album = new AlbumDatos();
            $album->tituloAlbum = $request->titulo;
            $album->fechaSubido = $request->fecha;
            $album->save();

            switch ($tipoAlbum) {
                case "1":
                    $revImg = $this->guardarImagenSiExiste($request->file('imagen'), 1);
                    $albumMusical = new AlbumMusical();
                    $albumMusical->albumDatos_idalbumDatos = $album->idalbumDatos;
                    $albumMusical->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;

                    // Guardar archivo de canción (MP3)
                    if ($request->hasFile('archivoDsCancion')) {
                        $audioPath = $request->file('archivoDsCancion')->store('audios', 'public');
                        $albumMusical->archivoDsCancion = $audioPath;
                    }

                    $albumMusical->save();

                    // Aca envion 
                    $this->creadoAlbumNotificar(5,  $album->tituloAlbum);

                    return redirect()->route('discografia')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum creado correctamente.',
                    ]);
                    break;


                case "2":
                    $albumVideo = new AlbumVideo();
                    // Asigna el ID del álbum
                    $albumVideo->albumDatos_idalbumDatos = $album->idalbumDatos;

                    // Asigna el archivo de video a la variable
                    $videoFile = $request->file('video');

                    // Ahora puedes usar $videoFile para almacenar el archivo
                    $path = $videoFile->store('video', 'public');

                    // Crea la instancia de Videos y guarda la ruta
                    $video = new Videos();
                    $video->subidaVideo = $path;
                    $video->fechaSubidoVideo = now();
                    $video->contenidoDescargable = 'No';
                    $video->save();

                    // Asigna el ID del video al álbum
                    $albumVideo->videos_idvideos = $video->idvideos;
                    $albumVideo->save();

                    // Aca envion 
                    $this->creadoAlbumNotificar(4,  $album->tituloAlbum);

                    // Redirigir a la ruta después de guardar los videos
                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum creado correctamente.',
                    ]);
                    break;

                case "3":
                    $revImg = $this->guardarImagenSiExiste($request->file('imagen'), 2);
                    $albumImagen = new AlbumImagenes();
                    $albumImagen->albumDatos_idalbumDatos = $album->idalbumDatos;
                    $albumImagen->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
                    $albumImagen->save();

                    // Aca envion 
                    $this->creadoAlbumNotificar(4,  $album->tituloAlbum);

                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum creado correctamente.',
                    ]);
                    break;
            }
        }
    }

    #ACTUALIZO SI ES QUE TIENE PARA ACTUALIZAR
    public function actualizarImagen($album, Request $request, $tipoAlbum)
    {
        $revImg = RevisionImagenes::find($album->revisionImagenes_idrevisionImagenescol);

        if ($revImg) {
            $imagen = Imagenes::find($revImg->imagenes_idimagenes);

            if ($imagen) {
                // Eliminar la referencia en albummusical o albumimagenes según el tipo de álbum
                $album2 = null;

                if ($tipoAlbum == 1) { // Musical
                    $album2 = AlbumMusical::where('revisionImagenes_idrevisionImagenescol', $revImg->idrevisionImagenescol)->first();
                } elseif ($tipoAlbum == 3) { // Imágenes
                    $album2 = AlbumImagenes::where('revisionImagenes_idrevisionImagenescol', $revImg->idrevisionImagenescol)->first();
                }

                if ($album2) {
                    $album->revisionImagenes_idrevisionImagenescol = null;
                    $album->save();
                }

                // Eliminar la revisión de imagen
                $revImg->delete();

                // Eliminar la imagen del almacenamiento
                Storage::disk('public')->delete($imagen->subidaImg);

                // Eliminar la imagen de la base de datos
                $imagen->delete();
            }
        }

        // Guardar nueva imagen y obtener el objeto de revisión de imagen
        if ($request->file('imagen')) {
            // Guarda la imagen y obtiene el objeto de revisión de imagen
            if ($tipoAlbum == 1) { // Musical
                $revImg = $this->guardarImagenSiExiste($request->file('imagen'), 1); // Pasa el archivo subido aquí
            } elseif ($tipoAlbum == 3) { // Imágenes
                $revImg = $this->guardarImagenSiExiste($request->file('imagen'), 2); // Pasa el archivo subido aquí
            }
            // Asigna el ID de revisión de imagen al álbum
            $album->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
            $album->save();
        }
    }

    public function manejoAlbumEliminarModificar(Request $request)
    {
        $accion = $request->accion;
        $tipoAlbum = (int) $request->tipoAlbum;
        $idAlbumEspecifico = $request->idAlbumEspecifico;

        if ($accion == '2') {
            if ($tipoAlbum == 2) {
                // Valida los datos
                $validator = Validator::make($request->all(), $this->rules(4));
            } else {
                // Valida los datos
                $validator = Validator::make($request->all(), $this->rules($tipoAlbum));
            }

            // Verifica si la validación falló
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('alertAlbum', [
                    'type' => 'Warning',
                    'message' => 'Error al cargar datos.',
                ]);
            }

            // MODIFICAR
            $albumDatos = AlbumDatos::findOrFail($idAlbumEspecifico);
            if ($request->has('titulo')) {
                $albumDatos->tituloAlbum = $request->titulo;
            }
            if ($request->has('fecha')) {
                $albumDatos->fechaSubido = $request->fecha;
            }

            $albumDatos->save();

            switch ($tipoAlbum) {
                case 1:
                    //Musical
                    $album = AlbumMusical::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                    $imagen = $album->revisionimagenes->imagenes->subidaImg ?? 'logo_inner.webp';

                    if ($request->file('imagen')) {
                        $this->actualizarImagen($album, $request, $tipoAlbum);
                    }

                    // Guardar archivo de canción (MP3)
                    if ($request->hasFile('archivoDsCancion')) {

                        // Borrar el archivo antiguo del almacenamiento
                        if ($album->cancion->archivoDsCancion) {
                            Storage::disk('public')->delete($album->cancion->archivoDsCancion);
                        }

                        // Subir el nuevo archivo de audio
                        $audioPath = $request->file('archivoDsCancion')->store('audios', 'public');
                        $album->cancion->archivoDsCancion = $audioPath;
                    }
                    $album->save();

                    return redirect()->route('discografia')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum modificado correctamente.',
                    ]);
                    break;
                case 2:
                    // Videos
                    $album = AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                    $idVideoEspecifico = $album->videos_idvideos;
                    $videoAnterior = Videos::find($idVideoEspecifico);

                    // Si se agregan videos, se deben crear nuevos álbumes con el mismo ID de álbum de datos
                    if ($request->has('video')) {

                        // Elimina del storage el video anterior
                        Storage::disk('public')->delete($videoAnterior->subidaVideo);

                        // Asigna el archivo de video a la variable
                        $videoFile = $request->file('video');

                        // Ahora puedes usar $videoFile para almacenar el archivo
                        $path = $videoFile->store('video', 'public');

                        // Crea la instancia de Videos y guarda la ruta
                        $video = new Videos();
                        $video->subidaVideo = $path;
                        $video->fechaSubidoVideo = now();
                        $video->contenidoDescargable = 'No';
                        $video->save();

                        // Asigna el ID del video al álbum
                        $album->videos_idvideos = $video->idvideos;
                        $album->save();

                        $videoAnterior->delete();
                    }



                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum modificado correctamente.',
                    ]);
                    break;
                case 3:
                    $album = AlbumImagenes::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                    $imagen = $album->revisionimagenes->imagenes->subidaImg ?? 'logo_inner.webp';

                    if ($request->file('imagen')) {
                        $this->actualizarImagen($album, $request, $tipoAlbum);
                    }

                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum modificado correctamente.',
                    ]);
                    break;
            }
        } elseif ($accion == '3') {
            switch ($tipoAlbum) {
                case 1:
                    $album = AlbumMusical::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                    $this->eliminarAlbumMusical($album);

                    break;

                case 2:
                    $albumVideos = AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->get();
                    foreach ($albumVideos as $alb) {
                        $this->eliminarVideo($alb);
                    }
                    // Eliminar los datos del álbum después de eliminar todas las imágenes
                    $albumDatos = AlbumDatos::find($idAlbumEspecifico);
                    if ($albumDatos) {
                        $albumDatos->delete();
                    }
                    break;

                case 3:
                    $albumImagenes = AlbumImagenes::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->get();

                    foreach ($albumImagenes as $alb) {
                        $this->eliminarImagen($alb);
                    }
                    // Eliminar los datos del álbum después de eliminar todas las imágenes
                    $albumDatos = AlbumDatos::find($idAlbumEspecifico);
                    if ($albumDatos) {
                        $albumDatos->delete();
                    }
                    break;
            }

            // Redireccionar con mensaje de éxito
            return redirect()->back()->with('alertAlbum', [
                'type' => 'Success',
                'message' => 'Álbum eliminado correctamente.',
            ]);
        }
    }

    /**
     * Elimina un álbum musical y sus canciones.
     */
    private function eliminarAlbumMusical($album)
    {
        if (!$album) return;
        // Eliminar canciones asociadas y sus archivos de audio
        $canciones = Cancion::where('albumMusical_idalbumMusical', $album->idalbumMusical)->get();
        foreach ($canciones as $cancion) {
            if ($cancion->archivoDsCancion) {
                Storage::disk('public')->delete($cancion->archivoDsCancion);
            }
            $cancion->delete();
        }
        // Eliminar el álbum
        $album->delete();

        // Eliminar la revisión de imagen
        $revImg = $album->revisionimagenes;
        if ($revImg) {
            $imagen = $revImg->imagenes;
            $revImg->delete();
            if ($imagen) {
                Storage::disk('public')->delete($imagen->subidaImg);
                $imagen->delete();
            }
        }

        // Eliminar los datos del álbum
        $album->albumDatos->delete();
    }

    /**
     * Elimina un video y su archivo asociado.
     */
    private function eliminarVideo($albumVideo)
    {
        if (!$albumVideo) return;

        // Obtener el ID del video
        $videoId = $albumVideo->videos_idvideos;

        // Eliminar la entrada de AlbumVideo
        $albumVideo->delete();

        // Buscar el video por ID y eliminarlo
        $tablaVideo = Videos::find($videoId);
        if ($tablaVideo) {
            Storage::disk('public')->delete($tablaVideo->subidaVideo);
            $tablaVideo->delete();
        }
    }

    /**
     * Elimina una imagen y su archivo asociado.
     */
    private function eliminarImagen($albumImagen)
    {
        if (!$albumImagen) return;

        // Eliminar la entrada de AlbumImagenes
        $albumImagen->delete();

        // Obtener la revisión de imagen
        $revImg = $albumImagen->revisionimagenes;
        if ($revImg) {
            // Eliminar la revisión de imagen
            $imagenes = $revImg->imagenes;
            $revImg->delete();

            // Verificar que la imagen no sea null y eliminarla
            if ($imagenes instanceof Imagenes) {
                Storage::disk('public')->delete($imagenes->subidaImg);
                $imagenes->delete();
            }
        }
    }

    #Elimino objeto especifico
    public function eliminarObjeto(Request $request)
    {
        // Obtener valores enviados desde el formulario
        $objeto = $request->input('idAlbumEspecifico');
        $tipo = $request->input('tipo');
        // Buscar el objeto basado en el tipo
        $albumMuestra = ($tipo == 1)
            ? AlbumVideo::find($objeto)
            : AlbumImagenes::find($objeto);

        // Verificar si se encontró el objeto y eliminarlo
        if ($albumMuestra) {
            if ($tipo == 1) {
                $this->eliminarVideo($albumMuestra); // Eliminar el video si el tipo es 1
            } else {
                $this->eliminarImagen($albumMuestra); // Eliminar la imagen si el tipo es diferente de 1
            }
            // Redireccionar con mensaje de éxito
            return redirect()->back()->with('success', [
                'type' => 'Success',
                'message' => 'Objeto eliminado correctamente.'
            ]);
        }
    }

    #Reglas de Ingresa datos
    public function reglas($tipo)
    {
        $rules = [];
        switch ($tipo) {
            case 1:
                // Álbum de tipo 1: varios videos
                $rules['videos'] = 'required|array'; // Cambia 'video' a 'videos'
                $rules['videos.*'] = 'file|mimes:mp4,mov,avi,mkv|max:20480'; // Validación para cada video
                break;
            case 2:
                // Álbum de tipo 2: varias imágenes
                $rules['imagenes'] = 'required|array';
                $rules['imagenes.*'] = 'image|mimes:jpeg,png,jpg,gif|max:2048'; // Validación para cada imagen
                break;
        }
        return $rules;
    }

    #Agregar videos/imagenes a albums especificos
    public function agregarVideoAlbum(Request $request)
    {
        $albumId = $request->input('idAlbumEspecifico');
        $tipo = $request->input('tipo');


        $validator = Validator::make($request->all(), $this->reglas($tipo));

        // Verifica si la validación falló
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertAlbum', [
                'type' => 'Warning',
                'message' => 'Error al cargar datos.',
            ]);
        }

        if ($tipo == 1) {
            // Procesar videos
            foreach ($request->file('videos') as $videoFile) {
                if ($videoFile->isValid()) {
                    $albumVideo = new AlbumVideo();
                    $albumVideo->albumDatos_idalbumDatos = $albumId;

                    $path = $videoFile->store('video', 'public');

                    $video = new Videos();
                    $video->subidaVideo = $path;
                    $video->fechaSubidoVideo = now();
                    $video->contenidoDescargable = 'No';
                    $video->save();

                    $albumVideo->videos_idvideos = $video->idvideos;
                    $albumVideo->save();
                } else {
                    return redirect()->back()->withErrors('Uno o más archivos de video son inválidos.');
                }
            }
            // Aca envion 
            $this->creadoAlbumNotificar(4,  'Videos');
            return redirect()->back()->with('alertAlbum', [
                'type' => 'Success',
                'message' => 'Videos añadidos correctamente.',
            ]);
        } else {
            // Procesar imágenes
            foreach ($request->file('imagenes') as $imagenFile) {
                if ($imagenFile->isValid()) {
                    $revImg = $this->guardarImagenSiExiste($imagenFile, $tipo);
                    $albumImagen = new AlbumImagenes();
                    $albumImagen->albumDatos_idalbumDatos = $albumId;
                    $albumImagen->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
                    $albumImagen->save();
                } else {
                    return redirect()->back()->withErrors('Uno o más archivos de imagen son inválidos.');
                }
            }
            // Aca envion 
            $this->creadoAlbumNotificar(4,  'Imágenes');
            return redirect()->back()->with('alertAlbum', [
                'type' => 'Success',
                'message' => 'Imágenes añadidas correctamente.',
            ]);
        }
    }

    ##ALBUM INTERNO
    public function mostrarDeUno($idAlbumEspecifico, $tipo)
    {
        $albumDato = AlbumDatos::find($idAlbumEspecifico);

        $idAlbumDato = $albumDato->idalbumDatos;
        $titulo = $albumDato->tituloAlbum;
        $fecha = $albumDato->fechaSubido;

        $albumMuestra = ($tipo == 1)
            ? AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->get()
            : AlbumImagenes::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->get();

        $medios = [];

        foreach ($albumMuestra as $objetoAlbum) {
            if ($tipo == 1) {
                $idMuestra = $objetoAlbum->idalbumVideo;
                $idObjetoEspecifico = $objetoAlbum->videos_idvideos;
                $rutaEspecifica = $objetoAlbum->videos->subidaVideo;
            } else {
                $idMuestra = $objetoAlbum->albumImagenescol;
                $idObjetoEspecifico = $objetoAlbum->revisionImagenes_idrevisionImagenescol;
                $rutaEspecifica = $objetoAlbum->revisionImagenes->imagenes->subidaImg;
            }

            $medios[$idMuestra] = [
                'idEspecificoObjeto' => $idObjetoEspecifico,
                'rutaEspecifica' => $rutaEspecifica
            ];
        }

        return view('components.galeria-interna', [
            'idDato' => $idAlbumDato,
            'titulo' => $titulo,
            'fecha' => $fecha,
            'medios' => $medios,
            'tipo' => $tipo
        ]);
    }
}

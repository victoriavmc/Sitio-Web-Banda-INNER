<?php

namespace App\Http\Controllers;

use App\Models\AlbumDatos;
use App\Models\AlbumImagenes;
use App\Models\AlbumMusical;
use App\Models\AlbumVideo;
use App\Models\Cancion;
use App\Models\DatosPersonales;
use App\Models\Imagenes;
use App\Models\RevisionImagenes;
use App\Models\Videos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    public function manejarAlbum(Request $request)
    {
        $accion = (int) $request->accion;
        $tipoAlbum = (int) $request->tipoAlbum;

        $idAlbumEspecifico = null;

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


        $imagen = 'imagen_por_defecto.jpg'; // Valor por defecto

        switch ($accion) {
            case 1:
                return view('components.manejo-album', compact('accion', 'tipoAlbum', 'titulo', 'imagen'));
                break;

            case 2:

                $idAlbumEspecifico = (int) $request->idAlbumEspecifico;

                $album = AlbumDatos::find($idAlbumEspecifico);

                if ($album) {
                    $tituloAlbum = $album->tituloAlbum;
                    $fechaSubida = $album->fechaSubido;

                    $albumMusical = AlbumMusical::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                    if ($albumMusical) {
                        $revisionImagen = $albumMusical->revisionimagenes ?? null;
                        $imagen = $revisionImagen ? $revisionImagen->imagenes->subidaImg : 'imagen_por_defecto.jpg';
                    }

                    return view('components.manejo-album', compact('accion', 'tipoAlbum', 'idAlbumEspecifico', 'titulo', 'tituloAlbum', 'fechaSubida', 'imagen'));
                }
                break;

            case 3:
                // Manejo para otro caso
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
            $rules['imagen'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($tipoAlbum == 2) {
            // Álbum de tipo 2: solo videos
            $rules['videos.*'] = 'required|file|mimes:mp4,mov,avi,mkv|max:20480';
        } elseif ($tipoAlbum == 3) {
            // Álbum de tipo 3: varias imágenes
            $rules['imagenes'] = 'required|array|min:2'; // Al menos 2 imágenes
            $rules['imagenes.*'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048'; // Cada imagen
        }

        return $rules;
    }

    #GUARDO IMAGEN
    public function guardarImagenSiExiste($imagen)
    {
        if ($imagen && $imagen->isValid()) {
            $path = $imagen->store('img', 'public');
            $imagenModel = new Imagenes();
            $imagenModel->subidaImg = $path;
            $imagenModel->fechaSubidaImg = now();
            $imagenModel->save();

            $revImg = new RevisionImagenes();
            $revImg->usuarios_idusuarios = Auth::user()->idusuarios;
            $revImg->imagenes_idimagenes = $imagenModel->idimagenes;
            $revImg->tipodefoto_idtipodefoto = 6;
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
                    $revImg = $this->guardarImagenSiExiste($request->file('imagen'));
                    $albumMusical = new AlbumMusical();
                    $albumMusical->albumDatos_idalbumDatos = $album->idalbumDatos;
                    $albumMusical->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
                    $albumMusical->save();

                    return redirect()->route('discografia')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum creado correctamente.',
                    ]);
                    break;


                case "2":
                    foreach ($request->videos as $video) {
                        $albumVideo = new AlbumVideo();
                        // Asigna el ID del álbum
                        $albumVideo->albumDatos_idalbumDatos = $album->idalbumDatos;

                        // Guarda el video en el sistema de archivos y obtén la ruta
                        $path = $video->store('video', 'public');

                        $video = new Videos();
                        // Guarda la ruta en la base de datos
                        $video->subidaVideo = $path;
                        $video->fechaSubidoVideo = now();
                        $video->contenidoDescargable = 'No';
                        $video->save();
                        // Guardar el registro del video en la base de datos
                        $albumVideo->videos_idvideos = $video->idvideos;
                        $albumVideo->save();
                    }

                    // Redirigir a la ruta después de guardar los videos
                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum creado correctamente.',
                    ]);

                    break;
                case "3":
                    if ($request->hasFile('imagenes')) {
                        foreach ($request->file('imagenes') as $imagen) { // Usar file('imagenes') para múltiples archivos
                            $revImg = $this->guardarImagenSiExiste($imagen);
                            $albumImagenes = new AlbumImagenes();
                            $albumImagenes->albumDatos_idalbumDatos = $album->idalbumDatos;
                            $albumImagenes->revisionImagenes_idrevisionImagenescol = $revImg ? $revImg->idrevisionImagenescol : null;
                            $albumImagenes->save();
                        }
                    }

                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'success',
                        'message' => 'Álbum creado correctamente.',
                    ]);
            }
        }
    }

    #ACTUALIZO SI ES QUE TIENE PARA ACTUALIZAR
    public function actualizarImagen($album, Request $request)
    {
        $revImg = RevisionImagenes::find($album->revisionImagenes_idrevisionImagenescol);

        if ($revImg) {
            $imagen = Imagenes::find($revImg->imagenes_idimagenes);

            if ($imagen) {
                // Eliminar la referencia en albummusical, si es necesario
                $albumMusical = AlbumMusical::where('revisionImagenes_idrevisionImagenescol', $revImg->idrevisionImagenescol)->first();
                if ($albumMusical) {
                    $albumMusical->revisionImagenes_idrevisionImagenescol = null;
                    $albumMusical->save();
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
        $revImg = $this->guardarImagenSiExiste($request);
        $album->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;

        // Asegúrate de guardar el álbum si ha habido cambios
        $album->save();
    }

    public function manejoAlbumEliminarModificar(Request $request)
    {

        $accion = $request->accion;
        $tipoAlbum = (int) $request->tipoAlbum;
        $idAlbumEspecifico = $request->idAlbumEspecifico;



        if ($accion == '2') {
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
                    $imagen = $album->revisionimagenes->imagenes->subidaImg ?? 'imagen_por_defecto.jpg';

                    if ($request->file('imagen')) {
                        $this->actualizarImagen($album, $request);
                    }

                    $album->save();

                    return redirect()->route('discografia')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum modificado correctamente.',
                    ]);
                    break;
                case 2:
                    // Videos
                    $album = AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->get();

                    // Si se agregan videos, se deben crear nuevos álbumes con el mismo ID de álbum de datos
                    if ($request->has('videos')) { // Cambiar 'video' por 'videos' para que coincida con el nombre del input
                        foreach ($request->videos as $videoFile) {
                            // Guarda el video en el sistema de archivos y obtén la ruta
                            $path = $videoFile->store('video', 'public');

                            // Crea una nueva instancia del modelo Videos
                            $video = new Videos();
                            // Guarda la ruta y otros datos en la base de datos
                            $video->subidaVideo = $path;
                            $video->fechaSubidoVideo = now();
                            $video->contenidoDescargable = 'No'; // Esto puede ser dinámico si lo necesitas
                            $video->save();

                            // Crear un nuevo registro en AlbumVideo
                            $albumVideo = new AlbumVideo();
                            $albumVideo->albumDatos_idalbumDatos = $idAlbumEspecifico; // Asigna el ID del álbum
                            $albumVideo->videos_idvideos = $video->idvideos; // Relaciona el video guardado
                            $albumVideo->save(); // Guarda el álbum de video
                        }
                    }

                    // Si se desea eliminar un video, se debe mostrar primero todos los videos con el mismo id de álbum de datos
                    if ($request->has('eliminarVideo')) {
                        $idVideoEspecifico = $request->eliminarVideo;

                        // Busca y elimina el video específico del álbum
                        $albumVideo = AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)
                            ->where('videos_idvideos', $idVideoEspecifico)
                            ->first();

                        if ($albumVideo) { // Asegúrate de que el álbum de video exista antes de intentar eliminarlo
                            $albumVideo->delete();
                            // También puedes eliminar el video del sistema de archivos si lo deseas
                            $video = Videos::find($idVideoEspecifico);
                            if ($video) {
                                Storage::disk('public')->delete($video->subidaVideo); // Eliminar el video del almacenamiento
                                $video->delete(); // Eliminar el video de la base de datos
                            }
                        }
                    }

                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum modificado correctamente.',
                    ]);
                    break;
                case 3:
                    // Imagenes
                    $album = AlbumImagenes::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->get();
                    // Si se agregan videos, se deben crear nuevos álbumes con el mismo ID de álbum de datos
                    if ($request->hasFile('imagenes')) {
                        foreach ($request->file('imagenes') as $imagen) { // Usar file('imagenes') para múltiples archivos
                            $revImg = $this->guardarImagenSiExiste($imagen);
                            $albumImagenes = new AlbumImagenes();
                            $albumImagenes->albumDatos_idalbumDatos = $idAlbumEspecifico;
                            $albumImagenes->revisionImagenes_idrevisionImagenescol = $revImg ? $revImg->idrevisionImagenescol : null;
                            $albumImagenes->save();
                        }
                    }

                    // Si se desea eliminar una imagen, se debe mostrar primero todas las imagenes con el mismo id de álbum de datos
                    if ($request->has('eliminarVideo')) {
                        $idVideoEspecifico = $request->eliminarVideo;

                        // Busca y elimina el video específico del álbum
                        $albumVideo = AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)
                            ->where('videos_idvideos', $idVideoEspecifico)
                            ->first();

                        if ($albumVideo) { // Asegúrate de que el álbum de video exista antes de intentar eliminarlo
                            $albumVideo->delete();
                            // También puedes eliminar el video del sistema de archivos si lo deseas
                            $video = Videos::find($idVideoEspecifico);
                            if ($video) {
                                Storage::disk('public')->delete($video->subidaVideo); // Eliminar el video del almacenamiento
                                $video->delete(); // Eliminar el video de la base de datos
                            }
                        }
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
                    break;

                case 3:
                    $albumImagenes = AlbumImagenes::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->get();
                    foreach ($albumImagenes as $alb) {
                        $this->eliminarImagen($alb);
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

        // Eliminar canciones asociadas
        Cancion::where('albumMusical_idalbumMusical', $album->idalbumMusical)->delete();

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
}

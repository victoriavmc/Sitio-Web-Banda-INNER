<?php

namespace App\Http\Controllers;

use App\Models\AlbumDatos;
use App\Models\AlbumImagenes;
use App\Models\AlbumMusical;
use App\Models\AlbumVideo;
use App\Models\Cancion;
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


        $imagen = 'imagen_por_defecto.jpg'; // Valor por defecto

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
                                $imagen = $revisionImagen ? $revisionImagen->imagenes->subidaImg : 'imagen_por_defecto.jpg';
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
                                $imagen = $revisionImagen ? $revisionImagen->imagenes->subidaImg : 'imagen_por_defecto.jpg';
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
            $rules['imagen'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($tipoAlbum == 2) {
            // Álbum de tipo 2: solo un video
            $rules['video'] = 'required|file|mimes:mp4,mov,avi,mkv|max:20480';
        } elseif ($tipoAlbum == 3) {
            // Álbum de tipo 3: solo una imagen
            $rules['imagen'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
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

                    // Redirigir a la ruta después de guardar los videos
                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum creado correctamente.',
                    ]);

                    break;
                case "3":
                    $revImg = $this->guardarImagenSiExiste($request->file('imagen'));
                    $albumImagen = new AlbumImagenes();
                    $albumImagen->albumDatos_idalbumDatos = $album->idalbumDatos;
                    $albumImagen->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
                    $albumImagen->save();

                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'success',
                        'message' => 'Álbum creado correctamente.',
                    ]);
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
            $revImg = $this->guardarImagenSiExiste($request->file('imagen')); // Pasa el archivo subido aquí

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
        // Valida los datos
        $validator = Validator::make($request->all(), $this->rules($tipoAlbum));

        // Verifica si la validación falló
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertAlbum', [
                'type' => 'Warning',
                'message' => 'Error al cargar datos.',
            ]);
        }

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
                        $this->actualizarImagen($album, $request, $tipoAlbum);
                    }

                    return redirect()->route('discografia')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum modificado correctamente.',
                    ]);
                    break;
                case 2:
                    // Videos
                    $album = AlbumVideo::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                    $idVideoEspecifico = $album->videos_idvideos;
                    $video = Videos::find($idVideoEspecifico);

                    // Si se agregan videos, se deben crear nuevos álbumes con el mismo ID de álbum de datos
                    if ($request->has('videos')) {
                        $video->delete();
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
                    }

                    $album->save();

                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum modificado correctamente.',
                    ]);
                    break;
                case 3:
                    $album = AlbumImagenes::where('albumDatos_idalbumDatos', $idAlbumEspecifico)->first();
                    $imagen = $album->revisionimagenes->imagenes->subidaImg ?? 'imagen_por_defecto.jpg';

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

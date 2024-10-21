<?php

namespace App\Http\Controllers;

use App\Models\AlbumDatos;
use App\Models\AlbumImagenes;
use App\Models\AlbumMusical;
use App\Models\AlbumVideo;
use App\Models\Cancion;
use App\Models\Imagenes;
use App\Models\RevisionImagenes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Solo para tipo álbum 1
            'videos.*' => 'nullable|file|mimes:mp4,mov,avi,mkv|max:20480', // Solo para tipo álbum 2
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Solo para tipo álbum 3
        ];
    }

    #GUARDO IMAGEN
    public function guardarImagenSiExiste(Request $request)
    {
        if ($request->file('imagen')) {
            $path = $request->file('imagen')->store('img', 'public');
            $imagen = new Imagenes();
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
            $imagen->save();

            $revImg = new RevisionImagenes();
            $revImg->usuarios_idusuarios = Auth::user()->idusuarios;
            $revImg->imagenes_idimagenes = $imagen->idimagenes;
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
        $request->validate($this->rules());

        if ($accion == '1') {

            // Crea Album
            $album = new AlbumDatos();
            $album->tituloAlbum = $request->titulo;
            $album->fechaSubido = $request->fecha;
            $album->save();

            switch ($tipoAlbum) {
                case "1":
                    $revImg = $this->guardarImagenSiExiste($request);
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
                    // Tengo que guardar TODOS los videos que pasaron 
                    foreach ($request->videos as $video) {
                        $albumVideo->albumDatos_idalbumDatos = $album->idalbumDatos;
                        $path = $video->store('albumes/videos');
                        $albumVideo->videos_idvideos = $path;
                        $albumVideo->save();
                    }
                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum creado correctamente.',
                    ]);

                    break;
                case "3":
                    $albumImagenes = new AlbumImagenes();
                    // Tengo que guardar TODOS los Imageness que pasaron 
                    foreach ($request->imagenes as $imagen) {
                        $albumImagenes->albumDatos_idalbumDatos = $album->idalbumDatos;
                        $revImg = $this->guardarImagenSiExiste($imagen);
                        $albumImagenes->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
                        $albumImagenes->save();
                    }
                    break;
                    return redirect()->route('albumGaleria')->with('alertAlbum', [
                        'type' => 'Success',
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
                    # code...
                    break;
                case 3:
                    # code...
                    break;
            }
        } elseif ($accion == '3') {
            // ELIMINAR
            switch ($tipoAlbum) {
                case 1:
                    $album = AlbumMusical::findOrFail($idAlbumEspecifico);

                    $revImg = $album->revisionimagenes;

                    $canciones = Cancion::where('albumMusical_idalbumMusical', $idAlbumEspecifico)->get();
                    foreach ($canciones as $cancion) {
                        $cancion->delete();
                    }
                    // Comprobar si existe la revisión de imagen
                    if ($revImg) {
                        $imagen = $revImg->imagenes;
                        $album->delete();
                        $revImg->delete();
                        if ($imagen) {
                            // Eliminar la imagen del almacenamiento
                            Storage::disk('public')->delete($imagen->subidaImg);
                            // Eliminar la imagen de la base de datos
                            $imagen->delete();
                        }
                    }

                    $album->delete();

                    // Eliminar los datos del álbum
                    $album->albumDatos->delete();

                    return redirect()->back()->with('alertAlbum', [
                        'type' => 'Success',
                        'message' => 'Álbum eliminado correctamente.',
                    ]);

                    break;
                case 2:
                    # code...
                    break;
                case 3:
                    # code...
                    break;
            }
        }
    }
}

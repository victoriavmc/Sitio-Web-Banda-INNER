<?php

namespace App\Http\Controllers;

#Clases
use App\Models\AlbumDatos;
use App\Models\AlbumMusical;
use App\Models\Cancion;
use App\Models\Imagenes;
use App\Models\RevisionImagenes;
#Otros
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;

class AlbumMusicaController extends Controller
{

    public function indexAlbumMusica()
    {
        $listaAlbum = $this->mostrarAlbumnes();
        return view('utils.albumMusica.discografia', compact('listaAlbum'));
    }

    public function mostrarAlbumnes()
    {
        $listaAlbum = [];

        // Obtener todos los álbumes
        $albumes = AlbumMusical::all();

        // Recorrer cada álbum y extraer los datos
        foreach ($albumes as $album) {
            // Verificar si las relaciones existen para evitar errores
            $idalbum = $album->idalbumMusical ?? 'ID No disponible';
            $albumTitulo = $album->albumdatos->tituloAlbum ?? 'Título no disponible';
            $albumFecha = $album->albumdatos->fechaSubido ?? 'Fecha no disponible';
            $albumImagen = $album->revisionimagenes->imagenes->subidaImg ?? 'imagen_por_defecto.jpg';

            // Inicializar la lista de canciones para cada álbum
            $listacanciones = [];

            // Obtener las canciones relacionadas con el álbum
            $canciones = Cancion::where('albumMusical_idalbumMusical', $idalbum)->get();

            // Verificar si hay canciones antes de recorrer
            if ($canciones) {
                foreach ($canciones as $cancion) {

                    // Añadir los detalles de la canción: nombre, letra en español y letra en inglés
                    $listacanciones[] = [
                        'id' => $cancion->idcancion,
                        'titulo' => $cancion->tituloCancion,
                        'letra_en_espanol' => $cancion->letraEspCancion ?? 'Letra en español no disponible',
                        'letra_en_ingles' => $cancion->letraInglesCancion ?? 'Letra en inglés no disponible',
                    ];
                }
            }

            // Agregar los datos del álbum junto con las canciones
            $listaAlbum[] = [
                'id' => $idalbum,
                'titulo' => $albumTitulo,
                'fecha' => $albumFecha,
                'imagen' => $albumImagen,
                'canciones' => $listacanciones, // Guardar los detalles completos de las canciones
            ];
        }

        return $listaAlbum;
    }

    // ------------------ CRUD DE ÁLBUMES ------------------

    public function crearAlbum(Request $request)
    {
        $validator = $this->validateAlbum($request);

        if ($validator->fails()) {
            return $this->redirectWithError('Error al crear el álbum, verifique los datos.');
        }

        $albumDatos = $this->guardarDatosAlbum($request);
        $revImg = $this->guardarImagenSiExiste($request);

        $albumMusical = new AlbumMusical();
        $albumMusical->albumDatos_idalbumDatos = $albumDatos->idalbumDatos;
        $albumMusical->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
        $albumMusical->save();

        return redirect()->route('discografia')->with('alertAlbum', [
            'type' => 'Success',
            'message' => 'Álbum creado correctamente.',
        ]);
    }

    public function modificarAlbum(Request $request, $id)
    {
        $validator = $this->validateAlbum($request);

        if ($validator->fails()) {
            return $this->redirectWithError('Error al modificar el álbum, verifique los datos.');
        }

        $album = AlbumMusical::findOrFail($id);
        $this->actualizarDatosAlbum($request, $album->albumDatos_idalbumDatos);

        if ($request->file('imagen')) {
            $this->actualizarImagen($album, $request);
        }

        $album->save();

        return redirect()->route('discografia')->with('alertAlbum', [
            'type' => 'Success',
            'message' => 'Álbum modificado correctamente.',
        ]);
    }

    // Solicita
    public function validateAlbum(Request $request)
    {
        return Validator::make($request->all(), [
            'titulo' => 'required|max:255',
            'fecha' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
    }

    #Error
    public function redirectWithError($message)
    {
        return redirect()->back()->withInput()->with('alertAlbum', [
            'type' => 'Danger',
            'message' => $message,
        ]);
    }

    #Guardo ALBUM DATOS
    public function guardarDatosAlbum(Request $request)
    {
        $albumDatos = new AlbumDatos();
        $albumDatos->tituloAlbum = $request->titulo;
        $albumDatos->fechaSubido = $request->fecha;
        $albumDatos->save();

        return $albumDatos;
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

    #ACTUALIZO SI ES QUE TIENE PARA ACTUALIZAR
    public function actualizarDatosAlbum(Request $request, $idAlbumMusical)
    {
        $albumDatos = AlbumDatos::findOrFail($idAlbumMusical);
        if ($request->has('titulo')) {
            $albumDatos->tituloAlbum = $request->titulo;
        }
        if ($request->has('fecha')) {
            $albumDatos->fechaSubido = $request->fecha;
        }
        $albumDatos->save();
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


    // Formulario Crear Album
    public function formularioCrearAlbum()
    {
        return view('utils.albumMusica.formularioCrearAlbum');
    }

    // Formulario Editar Album
    public function formularioModificarAlbum($id)
    {
        $album = AlbumMusical::find($id);
        $imagen = $album->revisionimagenes->imagenes->subidaImg ?? 'imagen_por_defecto.jpg';
        return view('utils.albumMusica.formularioModificarAlbum', compact('album', 'imagen'));
    }


    // Eliminar Album
    public function eliminarAlbum($id)
    {
        $album = AlbumMusical::findOrFail($id);

        $revImg = $album->revisionimagenes;

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
    }
}

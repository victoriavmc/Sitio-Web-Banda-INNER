<?php

namespace App\Http\Controllers;

#Clases
use App\Models\AlbumDatos;
use App\Models\AlbumMusical;
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
            $canciones = $album->cancion;

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

    // Formulario Crear Album
    public function formularioCrearAlbum()
    {
        return view('utils.albumMusica.formularioCrearAlbum');
    }

    // Guardar Album
    public function crearAlbum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|max:255|unique:albumdatos,tituloAlbum',
            'fecha' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertAlbum', [
                'type' => 'Danger',
                'message' => 'Error al crear el album, verifique los datos.',
            ]);
        }

        $albumDatos = new AlbumDatos();
        $albumDatos->tituloAlbum = $request->titulo;
        $albumDatos->fechaSubido = $request->fecha;
        $albumDatos->save();

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
        }

        $albumMusical = new AlbumMusical();
        $albumMusical->albumDatos_idalbumDatos = $albumDatos->idalbumDatos;
        $albumMusical->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol ?? null;
        $albumMusical->save();

        return redirect()->route('discografia')->with('alertAlbum', [
            'type' => 'Success',
            'message' => 'Álbum creado correctamente.',
        ]);
    }

    // Formulario Editar Album
    public function formularioModificarAlbum($id)
    {
        $album = AlbumMusical::find($id);
        $imagen = $album->revisionimagenes->imagenes->subidaImg ?? 'imagen_por_defecto.jpg';
        return view('utils.albumMusica.formularioModificarAlbum', compact('album', 'imagen'));
    }

    // Actualizar Album
    public function modificarAlbum(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|max:255',
            'fecha' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertAlbum', [
                'type' => 'Danger',
                'message' => 'Error al modificar el album, verifique los datos.',
            ]);
        }

        $album = AlbumMusical::findOrFail($id);

        $albumDatos = $album->albumDatos;
        $albumDatos->tituloAlbum = $request->titulo;
        $albumDatos->fechaSubido = $request->fecha;
        $albumDatos->save();

        // Actualizar la imagen y borrar del storage la imagen anterior
        if ($request->file('imagen')) {
            $revImg = $album->revisionimagenes;
            $imagen = Imagenes::where('idimagenes', $revImg->imagenes_idimagenes)->first();

            if ($imagen) {
                Storage::disk('public')->delete($imagen->subidaImg);
                $imagen->delete();
            }

            $imagen = new Imagenes();
            $path = $request->file('imagen')->store('img', 'public');
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
            $imagen->save();

            $idimagen = $imagen->idimagenes;

            $revImg = new RevisionImagenes();
            $revImg->usuarios_idusuarios = Auth::user()->idusuarios;
            $revImg->imagenes_idimagenes = $idimagen;
            $revImg->tipodefoto_idtipodefoto = 6;
            $revImg->save();

            $album->revisionImagenes_idrevisionImagenescol = $revImg->idrevisionImagenescol;
        }

        $album->save();
        return redirect()->route('discografia')->with('alertAlbum', [
            'type' => 'Success',
            'message' => 'Álbum modificado correctamente.',
        ]);
    }

    // Eliminar Album
    public function eliminarAlbum($id)
    {
        $album = AlbumMusical::findOrFail($id);

        $revImg = $album->revisionimagenes;

        $imagen = $revImg->imagenes;

        $album->delete();

        $revImg->delete();

        if ($imagen) {
            Storage::disk('public')->delete($imagen->subidaImg);
            $imagen->delete();
        }

        $album->albumDatos->delete();

        return redirect()->back()->with('alertAlbum', [
            'type' => 'Success',
            'message' => 'Álbum eliminado correctamente.',
        ]);
    }
}

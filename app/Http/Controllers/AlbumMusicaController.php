<?php

namespace App\Http\Controllers;
#Clases
use App\Models\AlbumMusical;

#Otros
use Illuminate\Http\Request;
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
            $idalbum = $album->idAlbumMusical ?? 'ID No disponible';
            $albumTitulo = $album->albumdatos->tituloAlbum ?? 'Título no disponible';
            $albumFecha = $album->albumdatos->fechaSubido ?? 'Fecha no disponible';
            $albumImagen = $album->revisionimagenes->imagenes->subidaImg ?? 'imagen_por_defecto.jpg';

            // Inicializar la lista de canciones para cada álbum
            $listacanciones = [];

            // Obtener las canciones relacionadas con el álbum
            $canciones = $album->canciones;
            dd($album->canciones);

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
        $album = new AlbumMusical();
        $album->save();
        return redirect()->route('discografia')->with('alertAlbum', [
            'type' => 'Success',
            'message' => 'Álbum creado correctamente.',
        ]);
    }

    // Formulario Editar Album
    public function formularioModificarAlbum($id)
    {
        $album = AlbumMusical::findOrFail($id);
        return view('utils.albumMusica.formularioModificarAlbum', compact('album'));
    }

    // Actualizar Album
    public function modificarAlbum(Request $request, $id)
    {
        $album = AlbumMusical::findOrFail($id);
        $album->idAlbumDatos = $request->idAlbumDatos;
        $album->idRevisionImagenes = $request->idRevisionImagenes;
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
        $album->delete();
        return redirect()->back()->with('alertAlbum', [
            'type' => 'Success',
            'message' => 'Álbum eliminado correctamente.',
        ]);
    }
}

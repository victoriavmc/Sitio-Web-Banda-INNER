<?php

namespace App\Http\Controllers;

use App\Mail\msjNotificaciones;
use App\Models\AlbumMusical;
use App\Models\Cancion;
use App\Models\Notificaciones;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CancionController extends Controller
{
    //Validator
    public function validateIngreso(Request $request)
    {
        $rules = [
            'tituloCancion' => 'required|max:255',
            'letraEspCancion' => 'nullable|string',
            'letraInglesCancion' => 'nullable|string',
            'archivoDsCancion' => 'nullable|mimes:mp3,mp4,ogg,wav|max:51200',
        ];

        // Si el álbum no es correcto, requerir el nuevo id
        if ($request->input('album_correcto') === 'no') {
            $rules['otroAlbum'] = 'required|exists:albummusical,idalbumMusical'; // Validar que se seleccione un nuevo álbum
        } else {
            // Si es correcto, añadir la validación del id del álbum original
            $rules['idalbumMusical'] = 'required|exists:albummusical,idalbumMusical';
        }

        return Validator::make($request->all(), $rules);
    }

    //Error
    public function redirectWithError($validator)
    {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('alertCancion', [
                'type' => 'Danger',
                'message' => 'Error al guardar la canción, verifique los datos.'
            ]);
    }

    #Guardo audio #VER
    public function guardarAudioSiExiste(Cancion $cancion, Request $request)
    {
        // Verificar si se ha marcado la opción de eliminar el archivo
        if ($request->has('eliminarCancion') && $cancion->archivoDsCancion) {
            Storage::disk('public')->delete($cancion->archivoDsCancion);
            return null; // Retornamos null para eliminar la referencia en la base de datos
        }

        // Guardar el nuevo archivo si se ha subido uno
        if ($request->hasFile('archivoDsCancion')) {
            // Eliminar el archivo anterior si ya existe
            if ($cancion->archivoDsCancion) {
                Storage::disk('public')->delete($cancion->archivoDsCancion);
            }

            // Guardar el nuevo archivo de audio
            $filePath = $request->file('archivoDsCancion')->store('audio', 'public');
            return $filePath;
        }

        // Retornar el archivo existente si no se ha subido uno nuevo y no se marca eliminar
        return $cancion->archivoDsCancion;
    }

    //Cada que se cree algun album nuevo debe enviar notificacion al usuario que marco el tiponotificacion especifico
    public function creadoAlbumNotificar($tituloAlbum, $titulo)
    {
        // Recuperar las notificaciones según el tipo
        $notificados = Notificaciones::where('tipoNotificación_idtipoNotificación', 5)->get();

        foreach ($notificados as $noti) {
            $usuariosNotificar = $noti->usuarios_idusuarios;
            $maildeusuario = Usuario::find($usuariosNotificar);

            // Verificar que el usuario exista antes de intentar acceder a su correo
            if ($maildeusuario) {
                $correo = $maildeusuario->correoElectronicoUser;

                // Lógica para enviar el correo según el tipo de notificación
                // Lógica específica para álbum musical
                $msj = 'Se ha agregado al álbum musical: ' . $tituloAlbum . ' la canción: ' . $titulo;
                Mail::to($correo)->send(new msjNotificaciones('Canciones', $msj));
            }
        }
    }

    // Guardar canción
    public function guardarCancion(Request $request, $id)
    {
        $cancion = new Cancion();
        // Asignar datos de la canción
        $cancion->albumMusical_idalbumMusical = $id;
        $cancion->tituloCancion = $request->tituloCancion;
        $cancion->letraEspCancion = $request->letraEspCancion;
        $cancion->letraInglesCancion = $request->letraInglesCancion;

        // Manejar archivo de audio y guardar la ruta en la propiedad archivoDsCancion
        $archivoRuta = $this->guardarAudioSiExiste($cancion, $request);
        $cancion->archivoDsCancion = $archivoRuta;

        // Guardar la canción en la base de datos
        $cancion->save();

        $tituloAlbum = AlbumMusical::find($id);

        $this->creadoAlbumNotificar($tituloAlbum->albumDatos->tituloAlbum, $cancion->tituloCancion);

        return redirect()->route('discografia')->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción agregada correctamente.',
        ]);
    }

    #Actualizar
    public function actualizarDatosIngresados(Cancion $cancion, Request $request)
    {
        if ($request->input('album_correcto') === 'no') {
            $nuevoAlbumId = $request->input('otroAlbum');

            if (empty($nuevoAlbumId)) {
                throw ValidationException::withMessages([
                    'otroAlbum' => 'Se requiere seleccionar un nuevo álbum si se indica que no es el álbum correcto.',
                ]);
            }

            $cancion->albumMusical_idalbumMusical = $nuevoAlbumId;
        }

        // Actualizar los datos de la canción
        $cancion->tituloCancion = $request->tituloCancion;
        $cancion->letraEspCancion = $request->letraEspCancion;
        $cancion->letraInglesCancion = $request->letraInglesCancion;

        // Lógica de eliminación de archivo si se ha marcado la opción
        if ($request->has('eliminarCancion') && $cancion->archivoDsCancion) {
            Storage::delete('public/' . $cancion->archivoDsCancion);
            $cancion->archivoDsCancion = null; // Actualizamos a null en la base de datos
        }

        // Guardar el nuevo audio si se subió uno
        $cancion->archivoDsCancion = $this->guardarAudioSiExiste($cancion, $request);

        $cancion->save();
    }

    // Mostrar formulario de agregar canción o modificar
    public function formularioCrearCancion($id)
    {
        // Crear nueva canción
        $idAlbum = $id;
        $album = AlbumMusical::findOrFail($idAlbum);
        $tituloAlbum = $album->albumDatos->tituloAlbum;

        $listaCancion = [];
        $canciones = Cancion::where('albumMusical_idalbumMusical', $id)->get();

        if ($canciones->isEmpty()) {
        } else {
            foreach ($canciones as $cancion) {
                $idCancion = $cancion->idcancion;
                $tituloCancion = $cancion->tituloCancion;
                $letraEspCancion = $cancion->letraEspCancion;
                $letraInglesCancion = $cancion->letraInglesCancion;
                $descargable = $cancion->archivoDsCancion;


                $listaCancion[] = [
                    'idCancion' => $idCancion,
                    'tituloCancion' => $tituloCancion,
                    'letraEspCancion' => $letraEspCancion,
                    'letraInglesCancion' => $letraInglesCancion,
                    'descargable' => $descargable,
                ];
            }
        }
        return view('utils.albumMusica.formularioCrearCancion', compact('idAlbum', 'tituloAlbum', 'listaCancion'));
    }

    // Mostrar formulario para modificar una canción específica
    public function formularioModificarCancion(Request $request, $id)
    {
        $cancion = Cancion::findOrFail($id);
        // datos de que album es
        $idAlbum = $cancion->albumMusical_idalbumMusical;
        $album = AlbumMusical::findOrFail($idAlbum);
        $tituloAlbum = $album->albumDatos->tituloAlbum;
        $albumesDisponibles = AlbumMusical::all();

        // URL del archivo de audio actual
        $audioActualUrl = $cancion->archivoDsCancion ? asset('storage/' . $cancion->archivoDsCancion) : null;

        return view('utils.albumMusica.formularioModificarCancion', compact('cancion', 'tituloAlbum', 'albumesDisponibles', 'audioActualUrl'));
    }

    // Guardar cambios en una canción existente
    public function actualizarCancion(Request $request, $id)
    {
        $cancion = Cancion::findOrFail($id); // Obtener la canción por su ID

        $validator = $this->validateIngreso($request); // Validar los datos

        if ($validator->fails()) {
            return $this->redirectWithError($validator); // Redirigir con errores
        }

        // Actualizar los datos de la canción
        $this->actualizarDatosIngresados($cancion, $request);

        return redirect()->route('discografia')->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción actualizada correctamente.',
        ]);
    }

    public function eliminarCancion($id)
    {
        $cancion = Cancion::findOrFail($id);
        // Borrar el archivo antiguo del almacenamiento
        if ($cancion->archivoDsCancion) {
            Storage::disk('public')->delete($cancion->archivoDsCancion);
        }
        $cancion->delete();

        return redirect()->back()->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción eliminada correctamente.',
        ]);
    }
}

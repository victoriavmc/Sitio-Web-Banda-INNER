<?php

namespace App\Http\Controllers;

use App\Models\AlbumMusical;
use App\Models\Cancion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CancionController extends Controller
{
    //Validator
    public function validateIngreso(Request $request)
    {
        return Validator::make($request->all(), [
            'idalbumMusical' => 'required|exists:albummusical,idalbumMusical',
            'tituloCancion' => 'required|max:255',
            'letraEspCancion' => 'nullable|string',
            'letraInglesCancion' => 'nullable|string',
            'archivoDsCancion' => 'nullable|mimes:mp3,mp4,ogg,wav|max:51200',
        ]);
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
        if ($request->hasFile('archivoDsCancion')) {
            // Eliminar el archivo anterior si se está actualizando
            if ($cancion->archivoDsCancion) {
                Storage::disk('public')->delete($cancion->archivoDsCancion);
            }

            // Guardar el nuevo archivo de audio
            $filePath = $request->file('archivoDsCancion')->store('audio', 'public');
            return $cancion->archivoDsCancion = $filePath;
        }
    }

    // Guardar canción
    public function guardarCancion(Request $request, $id)
    {
        $cancion = new Cancion();
        // Asignar datos de la canción
        $cancion->idcancion = $cancion->idcancion;
        $cancion->albumMusical_idalbumMusical = $id;
        $cancion->tituloCancion = $request->tituloCancion;
        $cancion->letraEspCancion = $request->letraEspCancion;
        $cancion->letraInglesCancion = $request->letraInglesCancion;

        // Manejar archivo de audio
        $this->guardarAudioSiExiste($cancion, $request);

        $cancion->save();

        return redirect()->route('discografia')->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción agregada correctamente.',
        ]);
    }

    #Actualizar
    public function actualizarDatosIngresados(Cancion $cancion, Request $request)
    {

        // Actualizar los datos existentes
        $cancion->tituloCancion = $request->tituloCancion;
        $cancion->letraEspCancion = $request->letraEspCancion;
        $cancion->letraInglesCancion = $request->letraInglesCancion;
        // Guardar el nuevo audio si existe
        $cancion->archivoDsCancion = $this->guardarAudioSiExiste($cancion, $request);
        $cancion->save(); // Guardar los cambios en la canción
    }

    // Mostrar formulario de agregar canción o modificar
    public function formularioCrearCancion($id)
    {
        // Crear nueva canción
        $idAlbum = $id;
        $album = AlbumMusical::findOrFail($idAlbum);
        $tituloAlbum = $album->albumDatos->tituloAlbum;

        return view('utils.albumMusica.formularioCrearCancion', compact('idAlbum', 'tituloAlbum'));
    }

    // Mostrar formulario para modificar una canción específica
    public function formularioModificarCancion(Request $request, $id)
    {
        $cancion = Cancion::findOrFail($id);
        return view('utils.albumMusica.formularioCrearCancion', compact('cancion'));
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
        $cancion->delete();

        return redirect()->back()->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción eliminada correctamente.',
        ]);
    }
}

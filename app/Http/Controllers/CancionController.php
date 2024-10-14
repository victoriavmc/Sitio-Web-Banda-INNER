<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CancionController extends Controller
{
    // Mostrar formulario de agregar canción
    public function formularioCrearCancion()
    {
        return view('utils.albumMusica.formularioCrearCancion');
    }

    // Guardar canción
    public function CrearCancion(Request $request)
    {
        // $cancion = new Cancion();
        // $cancion->tituloCancion = $request->tituloCancion;
        // $cancion->letraEspCancion = $request->letraEspCancion;
        // $cancion->letraInglesCancion = $request->letraInglesCancion;
        // $cancion->save();
        return redirect()->route('discografia')->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción agregada correctamente.',
        ]);
    }

    // Mostrar formulario de editar canción
    public function formularioModificarCancion($id)
    {
        // $cancion = Cancion::findOrFail($id);
        return view('utils.albumMusica.formularioModificarCancion', compact('cancion'));
    }

    // Actualizar canción
    public function modificarCancion(Request $request, $id)
    {
        // $cancion = Cancion::findOrFail($id);
        // $cancion->tituloCancion = $request->tituloCancion;
        // $cancion->letraEspCancion = $request->letraEspCancion;
        // $cancion->letraInglesCancion = $request->letraInglesCancion;
        // $cancion->save();
        return redirect()->route('discografia')->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción actualizada correctamente.',
        ]);
    }

    // Eliminar cancion
    public function eliminarCancion($id)
    {
        // $cancion = Cancion::findOrFail($id);
        // $cancion->delete();
        return redirect()->back()->with('alertCancion', [
            'type' => 'Success',
            'message' => 'Canción eliminada correctamente.',
        ]);
    }
}

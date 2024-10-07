<?php

namespace App\Http\Controllers;

use App\Models\Imagenes;
use App\Models\LugarLocal;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use App\Models\UbicacionShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class eventosController extends Controller
{
    public function eventos()
    {
        $shows = Show::orderBy('fechashow', 'desc')->get();
        return view('events.eventos', compact('shows'));
    }

    public function formularioModificar($id)
    {
        $show = Show::findOrFail($id);
        $ubicaciones = UbicacionShow::all();
        return view('events.modificarevento', compact('show', 'ubicaciones'));
    }

    public function modificarEvento(Request $request, $id)
    {
        // Validaciones
        $request->validate([
            'lugar' => 'required|string|max:255',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'provincia' => 'required',
            'calle' => 'required|string|max:255',
            'numero' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener el show que se va a modificar
        $show = Show::findOrFail($id);

        // Actualizar los datos del show
        $show->LugarLocal->nombreLugar = $request->input('lugar');
        $show->fechashow = $request->input('fecha');
        $show->LugarLocal->calle = $request->input('calle');
        $show->LugarLocal->numero = $request->input('numero');
        $show->ubicacionShow_idubicacionShow = $request->input('provincia');

        // Verificación y guardado de la imagen si es que se subió
        if ($request->hasFile('imagen')) {
            // Aquí se maneja el guardado de la imagen
            $imagenes = $request->file('imagen');
            foreach ($imagenes as $imagen) {
                $imageName = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('imagenes/shows'), $imageName);
                // Guardar el nombre de la imagen o la ruta en la base de datos
                $show->imagen = $imageName;
            }
        }

        // Guardar los cambios
        $show->save();

        // Redirigir a la vista de eventos con un mensaje de éxito
        return redirect()->back()->with('success', 'El evento se ha modificado correctamente.');
    }

    public function eliminarEvento($id)
    {
        $show = Show::find($id);

        $revisionImagen = RevisionImagenes::find($show->revisionImagenes_idrevisionImagenescol);

        $show->delete();

        if ($revisionImagen) {
            // Obtener la imagen asociada a la revisión
            $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);

            // Eliminar la revisión de imagen
            $revisionImagen->delete();

            if ($imagen && Storage::exists($imagen->subidaImg)) {
                Storage::delete($imagen->subidaImg);
            }

            // Eliminar la imagen si existe
            if ($imagen) {
                $imagen->delete();
            }
        }

        return redirect(view('events.eventos'))->with('success', 'El evento se ha modificado correctamente.');
    }
}

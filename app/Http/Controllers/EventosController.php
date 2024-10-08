<?php

namespace App\Http\Controllers;

use App\Models\Imagenes;
use App\Models\LugarLocal;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use App\Models\UbicacionShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class eventosController extends Controller
{
    public function eventos()
    {
        $shows = Show::orderBy('fechashow', 'desc')->get();
        return view('events.eventos', compact('shows'));
    }

    public function formularioCrear()
    {
        $lugares = LugarLocal::all();
        $ubicaciones = UbicacionShow::all();
        return view('events.crearEvento', compact('ubicaciones', 'lugares'));
    }

    public function crearEvento(Request $request)
    {
        // Validar los campos
        $validator = Validator::make($request->all(), [
            'nuevo_lugar' => 'required_without:lugar|string|max:255',  // Requerido si no se selecciona un lugar existente
            'lugar' => 'required_without:nuevo_lugar|string|max:255',  // Requerido si no se agrega uno nuevo
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'provincia' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calle' => 'required_if:nuevo_lugar,!=,null|string|max:255',  // Solo requerido si se está agregando un nuevo lugar
            'numero' => 'required_if:nuevo_lugar,!=,null|numeric',  // Solo requerido si se está agregando un nuevo lugar
        ], [
            'nuevo_lugar.required_without' => 'Debe agregar un nuevo lugar o seleccionar uno existente.',
            'calle.required_if' => 'La calle es obligatoria cuando se agrega un nuevo lugar.',
            'numero.required_if' => 'El número es obligatorio cuando se agrega un nuevo lugar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Inicializar la variable para el ID del lugar
        $lugarId = null;

        // Crear el lugar si se seleccionó "Agregar uno nuevo"
        if ($request->filled('nuevo_lugar')) {
            // Crear un nuevo lugar
            $nuevoLugar = new LugarLocal();
            $nuevoLugar->nombreLugar = $request->input('nuevo_lugar');
            $nuevoLugar->calle = $request->input('calle');
            $nuevoLugar->numero = $request->input('numero');
            $nuevoLugar->save();

            $lugarId = $nuevoLugar->idlugarLocal; // Obtener el ID del nuevo lugar
        } else {
            // Usar el lugar existente
            $lugarId = $request->input('lugar');
        }

        // Verificar si $lugarId es un entero antes de continuar
        // if (!is_numeric($lugarId)) {
        //     return redirect()->back()->withErrors(['lugar' => 'El lugar seleccionado no es válido.'])->withInput();
        // }

        // Crear el evento (Show) utilizando el ID del lugar
        $evento = new Show();
        $evento->fechashow = $request->input('fecha');
        $evento->estadoShow = 'pendiente';
        $evento->ubicacionShow_idubicacionShow = $request->input('provincia');
        $evento->lugarLocal_idlugarLocal = $lugarId;

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('imagenes');
            $evento->update(['imagen_path' => $path]);
        }

        // Redirigir a la vista de eventos con un mensaje de éxito
        return redirect(route('eventos'))->with('alertCrear', [
            'type' => 'Success',
            'message' => 'Se ha creado el evento!',
        ]);
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
        return redirect(route('eventos'))->with('alertModificar', [
            'type' => 'Success',
            'message' => 'Se ha modificado el evento!',
        ]);
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

        return redirect()->back()->with('success', 'El evento se ha modificado correctamente.');
    }
}

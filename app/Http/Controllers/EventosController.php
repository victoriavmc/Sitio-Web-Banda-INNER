<?php

namespace App\Http\Controllers;

use App\Models\Imagenes;
use App\Models\LugarLocal;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use App\Models\UbicacionShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class eventosController extends Controller
{
    public function eventos(Request $request)
    {
        $query = Show::query();

        // Si hay una búsqueda, filtra los eventos
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('lugarlocal', function ($q) use ($search) {
                $q->where('nombreLugar', 'like', '%' . $search . '%')
                    ->orWhere('localidad', 'like', '%' . $search . '%')
                    ->orWhere('calle', 'like', '%' . $search . '%')
                    ->orWhere('numero', 'like', '%' . $search . '%');
            })
                ->orWhere('fechashow', 'like', '%' . $search . '%');
        }

        // Obtén los eventos ordenados por fecha
        $shows = $query->orderBy('fechashow', 'desc')->get();

        return view('events.eventos', compact('shows'));
    }

    public function lugaresCargados()
    {
        $shows = Show::orderBy('fechashow', 'desc')->get();
        $lugares = LugarLocal::all();
        return view('events.lugaresEventos', compact('shows', 'lugares'));
    }

    public function eliminarLugar($id)
    {
        $lugar = LugarLocal::find($id);
        try {
            $lugar->delete();
        } catch (\Throwable $th) {
            return redirect()->route('lugares-cargados')->with('alertBorrar', [
                'type' => 'Danger',
                'message' => 'No se ha podido eliminar, el lugar esta en uso!',
            ]);
        }

        return redirect()->route('lugares-cargados')->with('alertBorrar', [
            'type' => 'Success',
            'message' => 'Se ha eliminado el lugar!',
        ]);
    }

    public function formularioCrear()
    {
        $lugares = LugarLocal::all();
        $ubicaciones = UbicacionShow::all();
        return view('events.crearevento', compact('ubicaciones', 'lugares'));
    }

    public function crearEvento(Request $request)
    {
        // Validar los campos
        $validator = Validator::make($request->all(), [
            'nuevo_lugar' => 'required_without:lugar|string|max:255',
            'lugar' => 'required_without:nuevo_lugar|string|max:255',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'provincia' => 'required',
            'localidad' => 'required|string|min:3|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calle' => 'required_if:nuevo_lugar,!=,null|string|max:255',
            'numero' => 'required_if:nuevo_lugar,!=,null|numeric',
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
            $nuevoLugar->localidad = $request->input('localidad');
            $nuevoLugar->save();

            $lugarId = $nuevoLugar->idlugarLocal;
        } else {
            // Usar el lugar existente
            $lugarId = $request->input('lugar');
        }

        // Crear el evento (Show) utilizando el ID del lugar
        $evento = new Show();
        $evento->fechashow = $request->input('fecha');
        $evento->ubicacionShow_idubicacionShow = $request->input('provincia');
        $evento->lugarLocal_idlugarLocal = $lugarId;

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('img', 'public');

            $imagen = new Imagenes();
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            // Crear la revisión de la imagen
            $revisionImagen = new RevisionImagenes();
            $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
            $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
            $revisionImagen->tipodefoto_idtipoDeFoto = 5;
            $revisionImagen->save();

            // Asociar la revisión de la imagen al comentario
            $evento->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        $evento->save();

        // Redirigir a la vista de eventos con un mensaje de éxito
        return redirect()->route('eventos')->with('alertCrear', [
            'type' => 'Success',
            'message' => 'Se ha creado el evento!',
        ]);
    }


    public function formularioModificar($id)
    {
        $show = Show::findOrFail($id);
        $lugares = LugarLocal::all();
        $ubicaciones = UbicacionShow::all();
        return view('events.modificarevento', compact('show', 'ubicaciones', 'lugares'));
    }

    public function modificarEvento(Request $request, $id)
    {
        // Validaciones
        $validator = Validator::make($request->all(), [
            'nuevo_lugar' => 'required_without:lugar|string|max:255',
            'lugar' => 'required_without:nuevo_lugar|string|max:255',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'provincia' => 'required',
            'localidad' => 'required|string|min:3|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calle' => 'required_if:nuevo_lugar,!=,null|string|max:255',
            'numero' => 'required_if:nuevo_lugar,!=,null|numeric',
        ], [
            'nuevo_lugar.required_without' => 'Debe agregar un nuevo lugar o seleccionar uno existente.',
            'calle.required_if' => 'La calle es obligatoria cuando se agrega un nuevo lugar.',
            'numero.required_if' => 'El número es obligatorio cuando se agrega un nuevo lugar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el evento que se va a modificar
        $evento = Show::findOrFail($id);

        // Inicializar la variable para el ID del lugar
        $lugarId = null;

        // Si se seleccionó "Agregar un nuevo lugar"
        if ($request->filled('nuevo_lugar')) {
            // Crear un nuevo lugar
            $nuevoLugar = new LugarLocal();
            $nuevoLugar->nombreLugar = $request->input('nuevo_lugar');
            $nuevoLugar->calle = $request->input('calle');
            $nuevoLugar->numero = $request->input('numero');
            $nuevoLugar->localidad = $request->input('localidad');
            $nuevoLugar->save();

            $lugarId = $nuevoLugar->idlugarLocal;
        } else {
            // Usar el lugar existente
            $lugarId = $request->input('lugar');
        }

        // Actualizar los datos del evento
        $evento->fechashow = $request->input('fecha');
        $evento->estadoShow = 'pendiente';
        $evento->ubicacionShow_idubicacionShow = $request->input('provincia');
        $evento->lugarLocal_idlugarLocal = $lugarId;

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            $revisionImagen = RevisionImagenes::find($evento->revisionImagenes_idrevisionImagenescol);

            if ($revisionImagen) {
                // Obtener la imagen asociada a la revisión
                $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);

                $evento->revisionImagenes_idrevisionImagenescol = null;
                $evento->save();

                // Eliminar la revisión de imagen después de eliminar el evento
                $revisionImagen->delete();

                // Eliminar la imagen del almacenamiento y de la base de datos
                if ($imagen) {
                    if (Storage::disk('public')->exists($imagen->subidaImg)) {
                        Storage::disk('public')->delete($imagen->subidaImg);
                    }

                    $imagen->delete();
                }
            }

            // Subir la nueva imagen
            $path = $request->file('imagen')->store('img', 'public');

            // Guardar la nueva imagen en la tabla "imagenes"
            $imagen = new Imagenes();
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            // Crear la nueva revisión de la imagen
            $revisionImagen = new RevisionImagenes();
            $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
            $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
            $revisionImagen->tipodefoto_idtipoDeFoto = 5;
            $revisionImagen->save();

            // Asociar la nueva revisión de la imagen al evento
            $evento->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        // Guardar los cambios en el evento
        $evento->save();

        // Redirigir a la vista de eventos con un mensaje de éxito
        return redirect()->route('eventos')->with('alertModificar', [
            'type' => 'Success',
            'message' => 'Se ha modificado el evento!',
        ]);
    }

    public function eliminarEvento($id)
    {

        $show = Show::find($id);

        if ($show->revisionImagenes_idrevisionImagenescol) {
            // Obtener la revisión de imagen asociada
            $revisionImagen = RevisionImagenes::find($show->revisionImagenes_idrevisionImagenescol);

            if ($revisionImagen) {
                // Obtener la imagen asociada a la revisión
                $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);

                // Eliminar primero el evento (Show) para liberar la clave foránea
                $show->delete();

                // Eliminar la revisión de imagen después de eliminar el evento
                $revisionImagen->delete();

                // Eliminar la imagen del almacenamiento y de la base de datos
                if ($imagen) {
                    if (Storage::disk('public')->exists($imagen->subidaImg)) {
                        Storage::disk('public')->delete($imagen->subidaImg);
                    }

                    $imagen->delete();  // Eliminar la imagen de la base de datos
                }
            } else {
                // Eliminar el evento si no tiene revisión de imagen
                $show->delete();
            }
        } else {
            // Si no hay revisión de imagen, solo eliminar el evento
            $show->delete();
        }

        return redirect()->back()->with('alertBorrar', [
            'type' => 'Success',
            'message' => 'Se ha borrado el evento!',
        ]);
    }
}

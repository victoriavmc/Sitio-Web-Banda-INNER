<?php

namespace App\Http\Controllers;

use App\Models\Imagenes;
use App\Models\LugarLocal;
use App\Models\Notificaciones;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use App\Models\UbicacionShow;
use App\Models\Usuario;
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

    public function lugaresCargados(Request $request)
    {
        // Inicializamos las queries para ambas tablas
        $lugaresQuery = LugarLocal::query();
        $ubicacionesQuery = UbicacionShow::query();

        // Si existe un término de búsqueda, aplicamos los filtros
        if ($request->has('search') && $search = $request->input('search')) {
            // Filtrar en LugarLocal por nombreLugar, localidad, calle o número
            $lugaresQuery->where(function ($q) use ($search) {
                $q->where('nombreLugar', 'like', '%' . $search . '%')
                    ->orWhere('localidad', 'like', '%' . $search . '%')
                    ->orWhere('calle', 'like', '%' . $search . '%')
                    ->orWhere('numero', 'like', '%' . $search . '%');
            });

            // Filtrar en UbicacionShow por provinciaLugar o paisLugar
            $ubicacionesQuery->where(function ($q) use ($search) {
                $q->where('provinciaLugar', 'like', '%' . $search . '%')
                    ->orWhere('paisLugar', 'like', '%' . $search . '%');
            });
        }

        // Obtener todos los registros si no hay búsqueda
        $lugares = $lugaresQuery->get();
        $ubicaciones = $ubicacionesQuery->get();

        // Obtener todos los shows (puedes adaptarlo si también quieres filtrar por shows)
        $shows = Show::orderBy('fechashow', 'desc')->get();

        // Retornar la vista con los datos obtenidos
        return view('events.lugaresEventos', compact('shows', 'lugares', 'ubicaciones'));
    }

    public function eliminarLugar($id)
    {
        $lugar = LugarLocal::find($id);

        try {
            $lugar->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->with('alertBorrar', [
                'type' => 'Danger',
                'message' => 'No se ha podido eliminar, el lugar esta en uso!',
            ]);
        }

        return redirect()->back()->with('alertBorrar', [
            'type' => 'Success',
            'message' => 'Se ha eliminado el lugar con exito!',
        ]);
    }

    public function eliminarUbicacion($id)
    {
        $ubicacion = UbicacionShow::find($id);
        try {
            $ubicacion->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->with('alertBorrar', [
                'type' => 'Danger',
                'message' => 'No se ha podido eliminar, la ubicacion esta en uso!',
            ]);
        }

        return redirect()->back()->with('alertBorrar', [
            'type' => 'Success',
            'message' => 'Se ha eliminado la ubicacion con exito!',
        ]);
    }

    public function modificarlugar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombreLugar' => 'required|min:3|max:255',
            'localidad' => 'string|max:255',
            'calle' => 'required|min:3|max:255',
            'numero' => 'max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertModificar', [
                'type' => 'Danger',
                'message' => 'Error al modificar el lugar, verifique los datos.',
            ]);
        }

        $lugar = LugarLocal::find($id);
        $lugar->nombreLugar = $request->input('nombreLugar');
        $lugar->localidad = $request->input('localidad');
        $lugar->calle = $request->input('calle');
        $lugar->numero = $request->input('numero');
        $lugar->save();

        return redirect()->route('lugares-cargados')->with('alertModificar', [
            'type' => 'Success',
            'message' => 'Se ha modificado el lugar!',
        ]);
    }

    public function modificarUbicacion(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'provinciaLugar' => 'required|min:3|max:255',
            'paisLugar' => 'required|min:3|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('alertModificar', [
                'type' => 'Danger',
                'message' => 'Error al modificar la ubicación, verifique los datos.',
            ]);
        }

        $ubicacion = UbicacionShow::find($id);
        $ubicacion->provinciaLugar = $request->input('provinciaLugar');
        $ubicacion->paisLugar = $request->input('paisLugar');
        $ubicacion->save();

        return redirect()->route('lugares-cargados')->with('alertModificar', [
            'type' => 'Success',
            'message' => 'Se ha modificado la ubicacion!',
        ]);
    }

    public function formularioCrear()
    {
        $lugares = LugarLocal::all();
        $ubicaciones = UbicacionShow::all();
        return view('events.crearevento', compact('ubicaciones', 'lugares'));
    }


    //Cada que se cree algun album nuevo debe enviar notificacion al usuario que marco el tiponotificacion especifico
    public function creadoAlbumNotificar($tituloShow)
    {
        // Recuperar las notificaciones según el tipo
        $notificados = Notificaciones::where('tipoNotificación_idtipoNotificación', 1)->get();

        foreach ($notificados as $noti) {
            $usuariosNotificar = $noti->usuarios_idusuarios;
            $maildeusuario = Usuario::find($usuariosNotificar);

            // Verificar que el usuario exista antes de intentar acceder a su correo
            if ($maildeusuario) {
                $correo = $maildeusuario->correoElectronicoUser;

                // Lógica para enviar el correo según el tipo de notificación
                // Lógica específica para Shows
                // $tituloAlbum paso el titulo del album y titulo de cancion
                // Mail::to($correo)->send(new NotificacionNuevaMusical($album));

            }
        }
    }

    public function crearEvento(Request $request)
    {
        // Validar los campos
        $validator = Validator::make($request->all(), [
            'nuevo_lugar' => 'required_without:lugar|string|max:255',
            'lugar' => 'required_without:nuevo_lugar|string|max:255',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'provincia' => 'required_without:nuevo_provincia|string|max:255',
            'nuevo_provincia' => 'required_without:provincia|string|max:255',
            'pais' => 'required_if:nuevo_provincia,!=,null|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calle' => 'required_if:nuevo_lugar,!=,null|string|max:255',
            'numero' => 'required_if:nuevo_lugar,!=,null|numeric',
            'linkCompra' => 'required|url|min:3|max:255'
        ], [
            'nuevo_lugar.required_without' => 'Debe agregar un nuevo lugar o seleccionar uno existente.',
            'calle.required_if' => 'La calle es obligatoria cuando se agrega un nuevo lugar.',
            'numero.required_if' => 'El número es obligatorio cuando se agrega un nuevo lugar.',
            'nuevo_provincia.required_without' => 'Debe agregar una nueva provincia o seleccionar una existente.',
            'pais.required_if' => 'El país es obligatorio cuando se agrega una nueva provincia.',
            'localidal.required_if' => 'La localidad es obligatoria cuando se agrega una nueva provincia.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Inicializar la variable para el ID del lugar y la ubicación
        $lugarId = null;
        $ubicacionId = null;

        // Crear el lugar si se seleccionó "Agregar uno nuevo"
        if ($request->filled('nuevo_lugar')) {
            $nuevoLugar = new LugarLocal();
            $nuevoLugar->nombreLugar = $request->input('nuevo_lugar');
            $nuevoLugar->calle = $request->input('calle');
            $nuevoLugar->numero = $request->input('numero');
            $nuevoLugar->localidad = $request->input('localidad');
            $nuevoLugar->save();

            $lugarId = $nuevoLugar->idlugarLocal;
        } else {
            $lugarId = $request->input('lugar');
        }

        // Crear la ubicación si se seleccionó "Agregar una nueva"
        if ($request->filled('nuevo_provincia')) {
            $nuevaUbicacion = new UbicacionShow();
            $nuevaUbicacion->provinciaLugar = $request->input('nuevo_provincia');
            $nuevaUbicacion->paisLugar = $request->input('pais');
            $nuevaUbicacion->save();

            $ubicacionId = $nuevaUbicacion->idubicacionShow;
        } else {
            $ubicacionId = $request->input('provincia');
        }

        // Crear el evento (Show) utilizando el ID del lugar y la ubicación
        $evento = new Show();
        $evento->fechashow = $request->input('fecha');
        $evento->ubicacionShow_idubicacionShow = $ubicacionId;
        $evento->lugarLocal_idlugarLocal = $lugarId;
        $evento->linkCompraEntrada = $request->input('linkCompra');

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('img', 'public');

            $imagen = new Imagenes();
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            $revisionImagen = new RevisionImagenes();
            $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
            $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
            $revisionImagen->tipodefoto_idtipoDeFoto = 4;
            $revisionImagen->save();

            $evento->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        $evento->save();
        $msj = 'Tenemos un nuevo show! En ' . $nuevoLugar->nombreLugar . ' el día ' . $evento->fechashow . '.';
        $this->creadoAlbumNotificar($msj);

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
            'nuevo_lugar' => 'nullable|string|max:255',
            'lugar' => 'required_without:nuevo_lugar|string|max:255',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calle' => 'nullable|string|max:255',
            'numero' => 'nullable|numeric',
            'nuevo_provincia' => 'nullable|string|max:255',
            'pais' => 'required_if:nuevo_provincia,!=,null|string|max:255',
            'linkCompra' => 'required|url|min:3|max:255'
        ], [
            'nuevo_lugar.required_without' => 'Debe agregar un nuevo lugar o seleccionar uno existente.',
            'lugar.required_without' => 'Debe seleccionar un lugar si no está agregando uno nuevo.',
            'nuevo_provincia.required_without' => 'Debe agregar una nueva provincia o seleccionar una existente.',
            'pais.required_if' => 'El país es obligatorio cuando se agrega una nueva provincia.',
            'localidal.required_if' => 'La localidad es obligatoria cuando se agrega una nueva provincia.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el evento que se va a modificar
        $evento = Show::findOrFail($id);

        // Inicializar la variable para el ID del lugar y ubicación
        $lugarId = null;
        $ubicacionId = null;

        // Manejar la creación de una nueva ubicación
        if ($request->filled('nuevo_provincia') && $request->filled('pais')) {
            // Crear una nueva ubicación
            $nuevaUbicacion = new UbicacionShow();
            $nuevaUbicacion->provinciaLugar = $request->input('nuevo_provincia');
            $nuevaUbicacion->paisLugar = $request->input('pais');
            $nuevaUbicacion->save();

            // Obtener el ID de la nueva ubicación
            $ubicacionId = $nuevaUbicacion->idubicacionShow;
        } else {
            // Usar la ubicación existente
            $ubicacionId = $request->input('provincia');
        }

        // Manejar la creación de un nuevo lugar
        if ($request->filled('nuevo_lugar')) {
            $nuevoLugar = new LugarLocal();
            $nuevoLugar->nombreLugar = $request->input('nuevo_lugar');
            $nuevoLugar->calle = $request->input('calle');
            $nuevoLugar->numero = $request->input('numero');
            $nuevoLugar->localidad = $request->input('localidad');

            // Asociar la nueva ubicación al nuevo lugar
            $nuevoLugar->ubicacionShow_idubicacionShow = $ubicacionId;
            $nuevoLugar->save();
            $lugarId = $nuevoLugar->idlugarLocal; // Obtener el ID del nuevo lugar
        } else {
            // Usar el lugar existente
            $lugarId = $request->input('lugar');
        }

        // Actualizar los datos del evento
        $evento->fechashow = $request->input('fecha');
        $evento->ubicacionShow_idubicacionShow = $ubicacionId; // Asignar el ID de la ubicación
        $evento->lugarLocal_idlugarLocal = $lugarId; // Asignar el ID del lugar
        $evento->linkCompraEntrada = $request->input('linkCompra');

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior, si existe
            $revisionImagen = RevisionImagenes::find($evento->revisionImagenes_idrevisionImagenescol);

            if ($revisionImagen) {
                // Obtener la imagen asociada a la revisión
                $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);
                if ($imagen) {
                    if (Storage::disk('public')->exists($imagen->subidaImg)) {
                        Storage::disk('public')->delete($imagen->subidaImg);
                    }
                    $imagen->delete();
                }

                // Eliminar la revisión de imagen
                $revisionImagen->delete();
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
            $revisionImagen->tipodefoto_idtipoDeFoto = 4;
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

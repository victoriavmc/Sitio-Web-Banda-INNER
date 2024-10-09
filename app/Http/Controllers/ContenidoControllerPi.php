<?php

namespace App\Http\Controllers;

#CLASES
use App\Models\Actividad;
use App\Models\Comentarios;
use App\Models\Contenidos;
use App\Models\Imagenes;
use App\Models\ImagenesContenido;
use App\Models\LugarLocal;
use App\Models\RedesSociales;
use App\Models\RevisionImagenes;
use App\Models\Show;
use App\Models\Usuario;

#OTROS
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContenidoControllerPi extends Controller
{
    public $links;


    # Crear un nuevo comentario
    public function crearComentario(Request $request, $idContent)
    {
        // Validar los datos
        $request->validate([
            'contenido' => 'nullable|string|max:500|required_without_all:imagen',
            'imagen' => 'nullable|image|max:2048|required_without_all:contenido',
        ]);

        // Crear una nueva actividad
        $actividad = new Actividad();
        $actividad->save();

        // Crear un nuevo comentario
        $comentario = new Comentarios();
        $comentario->fechaComent = now();
        $comentario->descripcion = $request->contenido; // Asegúrate de usar 'contenido'
        $comentario->Actividad_idActividad = $actividad->idActividad; // Asociar la actividad creada
        $comentario->contenidos_idcontenidos = $idContent; // Asociar el contenido específico

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $imagen = new Imagenes();
            $rutaImagen = $request->file('imagen')->store('img', 'public');
            $imagen->subidaImg = $rutaImagen;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            // Crear la revisión de la imagen
            $revisionImagen = new RevisionImagenes();
            $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
            $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
            $revisionImagen->tipodefoto_idtipoDeFoto = 5; // Supongamos que '5' es el tipo de foto para comentarios
            $revisionImagen->save();

            // Asociar la revisión de la imagen al comentario
            $comentario->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        $comentario->save();

        return redirect()->route('foroUnico', ['data' => $idContent])->with('success', 'Comentario agregado exitosamente.');
    }

    #Modificar un comentario especifico
    public function modificarComentario(Request $request, $idComentario)
    {
        // Validar los datos
        $request->validate([
            'contenido' => 'nullable|string|max:500|required_without_all:imagen',
            'imagen' => 'nullable|image|max:2048|required_without_all:contenido',
        ]);

        // Recuperar el comentario existente
        $comentario = Comentarios::find($idComentario);

        if (!$comentario) {
            return redirect()->back()->with('error', 'Comentario no encontrado.');
        }

        // Actualizar el contenido del comentario
        $comentario->descripcion = $request->contenido;

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            // Solo eliminar la imagen anterior si se ha seleccionado una nueva
            if ($comentario->revisionImagenes_idrevisionImagenescol) {
                $revisionImagen = RevisionImagenes::find($comentario->revisionImagenes_idrevisionImagenescol);
                if ($revisionImagen && $revisionImagen->imagenes) { // Verifica que la imagen exista
                    // Eliminar la imagen antigua
                    Storage::disk('public')->delete($revisionImagen->imagenes->subidaImg);
                    $revisionImagen->delete(); // También eliminar la revisión de imagen si es necesario
                }
            }

            // Guardar la nueva imagen
            $imagen = new Imagenes();
            $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
            $imagen->subidaImg = $rutaImagen;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            // Crear la revisión de la nueva imagen
            $revisionImagen = new RevisionImagenes();
            $revisionImagen->usuarios_idusuarios = Auth::user()->idusuarios;
            $revisionImagen->imagenes_idimagenes = $imagen->idimagenes;
            $revisionImagen->tipodefoto_idtipoDeFoto = 5; // Supongamos que '5' es el tipo de foto para comentarios
            $revisionImagen->save();

            // Asociar la nueva revisión de la imagen al comentario
            $comentario->revisionImagenes_idrevisionImagenescol = $revisionImagen->idrevisionImagenescol;
        }

        // Si no se subió una nueva imagen, se mantendrá la imagen existente

        $comentario->save();

        return redirect()->route('foroUnico', ['data' => $comentario->contenidos_idcontenidos])->with('success', 'Comentario modificado exitosamente.');
    }

    #Agregar Reporte
    public function reportarActividad($idActividad)
    {
        $actividad = Actividad::findOrFail($idActividad);
        $actividad->reportar();
        return redirect()->back()->with('success', 'Actividad reportada.');
    }
}

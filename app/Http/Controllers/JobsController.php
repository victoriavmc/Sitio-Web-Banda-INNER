<?php

namespace App\Http\Controllers;
# Clases
use App\Models\Artistas;
use App\Models\Imagenes;
use App\Models\RevisionImagenes;
use App\Models\StaffExtra;

# Otros
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobsController extends Controller
{
    public function ImagenesContenido($idContent)
    {
        $rutasImg = [];

        // Recupero la imagen que coincide con el ID de la tabla revisión de imágenes
        $revisionImagenes = RevisionImagenes::find($idContent);

        // Verifico si hay datos en la revisión de imágenes
        if ($revisionImagenes) {
            // Obtengo el ID de la imagen
            $idImagen = $revisionImagenes->imagenes_idimagenes;

            // Entro a la tabla de imágenes
            $imagen = Imagenes::where('idimagenes', $idImagen)->first();

            // Verifico si la imagen existe
            if ($imagen) {
                // Obtengo la ruta de la imagen
                $rutaImg = $imagen->subidaImg;

                // Guardo la ruta en el array (en caso de múltiples imágenes)
                $rutasImg[] = $rutaImg;
            }
        }
        // Devuelvo la primera imagen si existe, o una cadena vacía si no se encuentra nada
        return !empty($rutasImg) ? $rutasImg[0] : ''; // O devolver todo el array si esperas varias imágenes
    }

    // Método privado para generar la lista con informacion del Staff o Artista
    private function generarLista($entidades, $tipo)
    {
        $lista = [];
        // Recorro las entidades
        foreach ($entidades as $entidad) {
            if ($tipo === 'artista') {

                $nombre = $entidad->staffExtra->usuario->datosPersonales->nombreDP;
                $apellido = $entidad->staffExtra->usuario->datosPersonales->apellidoDP;
                $rol = $entidad->staffExtra->tipoStaff->nombreStaff;
                $redSocial = $entidad->staffExtra->redessociales->linkRedSocial ?? '#';
                $imagen = $this->ImagenesContenido($entidad->revisionImagenes_idrevisionImagenescol);
            } else {
                $nombre = $entidad->usuario->datosPersonales->nombreDP ?? 'Nombre no disponible';
                $apellido = $entidad->usuario->datosPersonales->apellidoDP ?? 'Apellido no disponible';
                $rol = $entidad->tipoStaff->nombreStaff ?? 'Rol no disponible';
                $redSocial = $entidad->redessociales->linkRedSocial ?? 'Sin enlace';

                // Recupero la imagen del staff
                $revisionImagen = RevisionImagenes::where('usuarios_idusuarios', $entidad->usuarios_idusuarios)->first();
                $imagen = $revisionImagen ? $revisionImagen->imagenes->subidaImg ?? null : null; // Imagen por defecto si no se encuentra
            }
            // Construyo un array con los detalles
            $lista[] = [
                'id' => $entidad->idartistas ?? $entidad->usuarios_idusuarios,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'rol' => $rol,
                'imagen' => $imagen,
                'link' => $redSocial,
            ];
        }
        return $lista;
    }

    # Vista Staff
    public function indexStaff()
    {
        // Recupero los Staff activos
        $staffs = StaffExtra::whereHas('usuario.datosPersonales.historialUsuario', function ($query) {
            $query->where('estado', 'Activo');
        })->get();

        // Generar la lista de staff
        $listaStaff = $this->generarLista($staffs, 'staff');

        // Retornar a la vista
        return view('content.job.staff', compact('listaStaff'));
    }

    // Vista Artistas
    public function indexArtistas()
    {
        // Recupero los artistas activos
        $artistas = Artistas::whereHas('staffExtra.usuario.datosPersonales.historialUsuario', function ($query) {
            $query->where('estado', 'Activo');
        })->get();

        // Generar la lista de artistas
        $listaArtistas = $this->generarLista($artistas, 'artista');

        // Retornar a la vista
        return view('content.job.artistas', compact('listaArtistas'));
    }

    #Modificar la imagen del artista
    public function modificarImagenArtista(Request $request, $id)
    {
        // Validar la imagen
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Encontrar el artista por ID
        $artista = Artistas::find($id);
        $userId = $artista->staffExtra->usuarios_idusuarios;

        // Verificar si ya existe una foto
        $existeFoto = RevisionImagenes::where('tipoDeFoto_idtipoDeFoto', 6)
            ->where('usuarios_idusuarios', $userId) // Cambiado a $userId
            ->first();

        if ($existeFoto != null) {
            // Obtener el registro de la imagen anterior
            $imagenAnterior = Imagenes::find($existeFoto->imagenes_idimagenes);

            // Eliminar el registro de la revisión anterior
            // Primero, eliminar la relación en el artista
            $artista->revisionImagenes_idrevisionImagenescol = null;
            $artista->save(); // Guardar los cambios en el artista

            $existeFoto->delete(); // Luego, eliminar la revisión

            // Ahora eliminar el archivo del almacenamiento
            if ($imagenAnterior) {
                Storage::disk('public')->delete($imagenAnterior->subidaImg);
                $imagenAnterior->delete();
            }
        }

        // Guardar la nueva imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('img', 'public');

            // Crear nuevo registro de imagen
            $imagen = new Imagenes();
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            // ID de la nueva imagen
            $idFoto = $imagen->idimagenes;

            // Guarda la imagen a lo que está relacionada
            $revisionImg = new RevisionImagenes();
            $revisionImg->usuarios_idusuarios = $userId; // Ahora se usa el ID del usuario
            $revisionImg->imagenes_idimagenes = $idFoto;
            $revisionImg->tipoDeFoto_idtipoDeFoto = 6;
            $revisionImg->save();

            // Actualizar el ID de la imagen en el artista
            $artista->revisionImagenes_idrevisionImagenescol = $revisionImg->idrevisionImagenescol;

            // Guardar los cambios en el artista
            $artista->save();

            // Redirigir a la ruta 'artistas'
            return redirect()->route('artistas')->with('success', 'Imagen actualizada con éxito.');
        }

        // Si no hay archivo, redirigir de nuevo con un mensaje de error
        return redirect()->route('artistas')->with('error', 'No se ha cargado ninguna imagen.');
    }
}

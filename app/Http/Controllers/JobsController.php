<?php

namespace App\Http\Controllers;
# Clases
use App\Models\Artistas;
use App\Models\Imagenes;
use App\Models\RevisionImagenes;
use App\Models\StaffExtra;

# Otros
use Illuminate\Http\Request;

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

    #Mostrar indexArtistas
    public function indexArtistas()
    {
        // Recupero los artistas
        $artistas = Artistas::all();
        $listaArtistas = [];

        // Recorro los artistas
        foreach ($artistas as $artista) {
            // Recupero los detalles del artista
            $idArtista = $artista->idartistas;
            $nombreArtista = $artista->staffExtra->usuario->datosPersonales->nombreDP;
            $apellidoArtista = $artista->staffExtra->usuario->datosPersonales->apellidoDP;
            $rol = $artista->staffExtra->tipoStaff->nombreStaff;
            $redSocial = $artista->staffExtra->redessociales->linkRedSocial;

            // Recupero la imagen del artista (esto será una cadena de una sola imagen)
            $imagenArtista = $this->ImagenesContenido($artista->revisionImagenes_idrevisionImagenescol);

            // Construyo un array con los detalles del artista
            $listaArtistas[] = [
                'id' => $idArtista,
                'nombre' => $nombreArtista,
                'apellido' => $apellidoArtista,
                'rol' => $rol,
                'imagen' => $imagenArtista, // Asegúrate de que esto sea una cadena
                'link' => $redSocial
            ];
        }
        // Retornar a la vista
        return view('/content/job/artistas', compact('listaArtistas'));
    }

    #Mostrar indexStaff
    public function indexStaff()
    {
        // Recupero los Staff
        $staffs = StaffExtra::all();
        $listaStaff = [];

        // Recorro los Staff
        foreach ($staffs as $staff) {
            // Recupero los detalles del staff
            $idStaffUsuario = $staff->usuarios_idusuarios;

            $nombrestaff = $staff->usuario->datosPersonales->nombreDP ?? 'Nombre no disponible';
            $apellidostaff = $staff->usuario->datosPersonales->apellidoDP ?? 'Apellido no disponible';
            $rol = $staff->tipoStaff->nombreStaff ?? 'Rol no disponible';
            $redSocial = $staff->redessociales->linkRedSocial ?? 'Sin enlace';

            // Recupero la imagen del staff
            $revisionImagen = RevisionImagenes::where('usuarios_idusuarios', $idStaffUsuario)->first();

            // Verificar si se encontró la revisión de imagen
            if ($revisionImagen) {
                $imagenstaff = $revisionImagen->imagenes->subidaImg ?? null; // Imagen por defecto si no se encuentra
            } else {
                $imagenstaff = null; // También será null si no hay revisión
            }

            // Construyo un array con los detalles del staff
            $listaStaff[] = [
                'nombre' => $nombrestaff,
                'apellido' => $apellidostaff,
                'rol' => $rol,
                'imagen' => $imagenstaff,
                'link' => $redSocial
            ];
        }
        // Retornar a la vista después de procesar todos los staffs
        return view('/content/job/Staff', compact('listaStaff'));
    }
}

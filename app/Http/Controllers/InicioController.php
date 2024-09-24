<?php

namespace App\Http\Controllers;

# CLASES
use App\Models\Contenidos;
use App\Models\Imagenes;
use App\Models\ImagenesContenido;
use App\Models\RevisionImagenes;
use App\Models\Show;

# OTROS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class inicioController extends Controller
{
    public function index()
    {
        $shows = $this->Eventos();
        $noticias = $this->soloCuatroNoticias();
        $noticiasImg = [];
        foreach ($noticias as $idnoticia) {
            $noticiasImg[$idnoticia->idcontenidos] = $this->VerImagenesContenido($idnoticia->idcontenidos);
        }

        return view('inicio', compact('shows', 'noticias', 'noticiasImg'));
    }

    public function Eventos()
    {
        $shows = Show::orderBy('fechashow', 'desc')->get();
        return $shows;
    }

    // Ordenar por fechaSubida, descendente y tomar las 4 primeras
    public function soloCuatroNoticias()
    {
        // Ordenar por fechaSubida, descendente
        $recuperoPublicaciones = Contenidos::where('tipoContenido_idtipoContenido', 2)
            ->orderBy('fechaSubida', 'desc')
            ->take(4)
            ->get();

        // Limitar la descripción a 30 palabras
        foreach ($recuperoPublicaciones as $publicacion) {
            $publicacion->descripcion = Str::words($publicacion->descripcion, 30);
        }

        return $recuperoPublicaciones;
    }

    # IMAGENES CONTENIDO
    public function VerImagenesContenido($data)
    {
        # Tengo que recuperar todas las imagen que coincidan con el idcontendio.
        $imagenes = ImagenesContenido::where('contenidos_idcontenidos', $data)->get();

        $rutasImg = []; // Array para almacenar las rutas de las imágenes

        foreach ($imagenes as $imgEspecifica) {
            # Obtengo el id/ids
            $idRevImg = $imgEspecifica->revisionImagenes_idrevisionImagenescol;

            # Revisión Imagenes para obtener el id de la imagen
            $revisionImagenes = RevisionImagenes::where('idrevisionImagenescol', $idRevImg)->first();

            if ($revisionImagenes) {
                // Obtengo IdImagen
                $idImagen = $revisionImagenes->imagenes_idimagenes;

                // Entro a la tabla de imágenes
                $imagen = Imagenes::where('idimagenes', $idImagen)->first();

                if ($imagen) {
                    // Obtengo la ruta de la imagen
                    $rutaImg = $imagen->subidaImg;

                    // Almaceno la ruta en el array
                    $rutasImg[] = $rutaImg; // Guardo las rutas sin clave para simplificar
                }
            }
        }
        # Devuelvo las rutas de la imagen
        return $rutasImg;
    }
}

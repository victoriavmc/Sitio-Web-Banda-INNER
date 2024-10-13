<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\Imagenes;
use App\Models\RevisionImagenes;
use App\Models\Usuario;
use App\Models\Actividad;
use App\Models\Comentarios;
use App\Models\Interacciones;
use App\Models\ImagenesContenido;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class ReportesController extends Controller
{
    #REPORTES

    #Busco Imagen de un Usuario Especifico (VER COMO USAR)
    public function buscarImagen($idUser)
    {
        // Ahora busco en la tabla revisionImagenes
        $imagenPerfil = RevisionImagenes::where('usuarios_idusuarios', $idUser)
            ->where('tipodefoto_idtipoDeFoto', 1)
            ->first();

        if ($imagenPerfil) {
            $idImagenP = $imagenPerfil->imagenes_idimagenes;

            // Ahora busco la imagen en la tabla imagenes
            $ubicacionImagen = Imagenes::where('idimagenes', $idImagenP)->first();

            return $ubicacionImagen ? $ubicacionImagen->subidaImg : null;
        }

        return null; // Si no hay imagen
    }

    // Función para obtener la ruta de las imágenes a partir de la revisión de imágenes
    public function RevImagen($revisionImagenes)
    {
        $rutasImg = []; // Inicializo el array para almacenar las rutas

        if ($revisionImagenes) {
            // Obtengo el ID de la imagen
            $idImagen = $revisionImagenes->imagenes_idimagenes;

            // Busco la imagen en la tabla de imágenes
            $imagen = Imagenes::where('idimagenes', $idImagen)->first();

            if ($imagen) {
                // Obtengo la ruta de la imagen
                $rutaImg = $imagen->subidaImg;

                // Almaceno la ruta en el array
                $rutasImg[] = $rutaImg;
            }
        }

        return $rutasImg; // Devuelvo el array de rutas
    }

    // Función para obtener las imágenes de contenido
    public function ImagenesContenido($idContent, $opcion)
    {
        $rutasImg = []; // Array para almacenar las rutas de las imágenes

        if ($opcion == 1) {
            // Recupero todas las imágenes que coincidan con el idContenido
            $imagenes = ImagenesContenido::where('contenidos_idcontenidos', $idContent)->get();

            foreach ($imagenes as $imgEspecifica) {
                // Obtengo el id de revisión de imágenes
                $idRevImg = $imgEspecifica->revisionImagenes_idrevisionImagenescol;

                // Busco la revisión de imágenes
                $revisionImagenes = RevisionImagenes::where('idrevisionImagenescol', $idRevImg)->first();

                // Si existe la revisión de imágenes, llamo a RevImagen
                if ($revisionImagenes) {
                    $rutasImg = array_merge($rutasImg, $this->RevImagen($revisionImagenes));
                }
            }
        } elseif ($opcion == 2) {
            // Recupero la imagen que coincida con el id de la tabla revisión imágenes
            $revisionImagenes = RevisionImagenes::find($idContent);

            // Llamo a la función RevImagen
            $rutasImg = $this->RevImagen($revisionImagenes);
        }

        // Devuelvo las rutas de las imágenes
        return $rutasImg;
    }

    #Redirigir a manejoreporte
    public function manejoreporte($id)
    {
        // Usuario
        $usuario = Usuario::find($id);

        // Datos personales
        $datosPersonales = $usuario->datosPersonales;

        // Reportes
        $reportes = $usuario->reportes;

        $imagen = $this->buscarImagen($id);

        // Mostrar Actividades en general del usuario
        $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

        // Almacenar datos de las actividades reportadas y no reportadas
        $listaActividadReportadaComentario = [];
        $listaActividadReportadaContenido = [];

        $listaActividadNOReportadaComentario = [];
        $listaActividadNOReportadaContenido = [];

        //IMAGENES
        $listaActividadReportadaContenidoImg = [];
        $listaActividadNOReportadaContenidoImg = [];

        // Actividad x actividad
        foreach ($actividades as $actividad) {
            // Obtener el ID de la actividad actual
            $actividadId = $actividad->idActividad;
            $tipoActividad = $actividad->tipoActividad_idtipoActividad;

            // Mostrar actividad específica: contar reportes
            $reportes = Interacciones::where('actividad_idActividad', $actividadId)
                ->where('reporte', '>', 0)
                ->select(DB::raw('COUNT(*) as totalReportes'))
                ->first();

            // Verificamos si hay reportes
            if ($reportes && $reportes->totalReportes > 0) {
                switch ($tipoActividad) {
                    case '1':
                        // Reportaron el Perfil
                        break;

                    case '2':
                        // Obtener comentarios relacionados a la actividad
                        $comentarios = Comentarios::where('Actividad_idActividad', $actividadId)->get();


                        // Recorrer los comentarios y almacenarlos en la lista
                        foreach ($comentarios as $comentario) {
                            $contenido = Contenidos::find($comentario->contenidos_idcontenidos); // Obtener el contenido relacionado

                            // Recuperar la imagen asociada al comentario
                            $rutaImagen = $this->ImagenesContenido($comentario->revisionImagenes_idrevisionImagenescol, 2);

                            $listaActividadReportadaComentario[] = [
                                'idComentario' => $comentario->idcomentarios,
                                'fechaComent' => $comentario->fechaComent,
                                'descripcion' => $comentario->descripcion,
                                'tituloContenido' => $contenido ? $contenido->titulo : null, // Agregar título del contenido
                                'id' => $contenido ? $contenido->idcontenidos : null,
                                'reportado' => true, // Marcamos como reportado
                                'rutaImagen' => $rutaImagen,
                            ];
                        }
                        break;

                    case '3':
                        // Reportaron el contenido  
                        // Obtener contenidos relacionados a la actividad
                        $contenidos = Contenidos::where('Actividad_idActividad', $actividadId)->get(); // Obtener todos los contenidos relacionados

                        foreach ($contenidos as $contenido) {

                            $listaActividadReportadaContenidoImg =  $this->ImagenesContenido($contenido->idcontenidos, 1);

                            $listaActividadReportadaContenido[] = [
                                'id' => $contenido->idcontenidos,
                                'fechaComent' => $contenido->fechaSubida,
                                'titulo' => $contenido->titulo,
                                'descripcion' => $contenido->descripcion,
                                'reportado' => true, // Marcamos como reportado
                                'rutaImagen' => $listaActividadReportadaContenidoImg,
                            ];
                        }
                        break;
                }
            } else {
                // Si no hay reportes

                switch ($tipoActividad) {
                    case '2':
                        // Obtener comentarios no reportados
                        $comentarios = Comentarios::where('Actividad_idActividad', $actividadId)->get();

                        foreach ($comentarios as $comentario) {
                            $contenido = Contenidos::find($comentario->contenidos_idcontenidos); // Obtener contenido relacionado

                            // Recuperar la imagen asociada al comentario
                            $rutaImagen = $this->ImagenesContenido($comentario->revisionImagenes_idrevisionImagenescol, 2);

                            $listaActividadNOReportadaComentario[] = [
                                'idComentario' => $comentario->idcomentarios,
                                'fechaComent' => $comentario->fechaComent,
                                'descripcion' => $comentario->descripcion,
                                'tituloContenido' => $contenido ? $contenido->titulo : null, // Título del contenido
                                'id' => $contenido ? $contenido->idcontenidos : null,
                                'reportado' => false, // Marcado como no reportado
                                'rutaImagen' => $rutaImagen,
                            ];
                        }

                        break;

                    case '3':
                        // Obtener contenidos no reportados
                        $contenidos = Contenidos::where('Actividad_idActividad', $actividadId)->get();

                        foreach ($contenidos as $contenido) {

                            $listaActividadNOReportadaContenidoImg =  $this->ImagenesContenido($contenido->idcontenidos, 1);

                            $listaActividadNOReportadaContenido[] = [
                                'id' => $contenido->idcontenidos,
                                'fechaComent' => $contenido->fechaSubida,
                                'titulo' => $contenido->titulo,
                                'descripcion' => $contenido->descripcion,
                                'reportado' => false, // Marcado como no reportado
                                'rutaImagen' => $listaActividadNOReportadaContenidoImg,
                            ];
                        }
                        break;
                }
            }
        }

        // Después del bucle calcular el total de actividades no reportadas
        $totalNoReportadas = count($listaActividadNOReportadaComentario) + count($listaActividadNOReportadaContenido);

        return view('profile.manejoreporte', compact(
            'usuario',
            'datosPersonales',
            'imagen',
            'actividades',
            'reportes',
            'listaActividadReportadaComentario',
            'listaActividadReportadaContenido',
            'listaActividadNOReportadaComentario',
            'listaActividadNOReportadaContenido',
            'totalNoReportadas' // Pasar el total correctamente
        ));
    }
}

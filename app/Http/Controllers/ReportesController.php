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
        $imagenPerfil = RevisionImagenes::where('usuarios_idusuarios', $idUser)
            ->where('tipodefoto_idtipoDeFoto', 1)
            ->first();

        return $imagenPerfil ? Imagenes::find($imagenPerfil->imagenes_idimagenes)->subidaImg : null;
    }

    // Obtener la Ruta de Imágenes desde Revisión de Imágenes
    public function obtenerRutaImagen($idRevision)
    {
        // Primero verifica si existe la revisión de imágenes
        $revision = RevisionImagenes::find($idRevision);

        if ($revision) {
            // Luego verifica si se encuentra la imagen relacionada
            $imagen = Imagenes::find($revision->imagenes_idimagenes);
            return $imagen ? [$imagen->subidaImg] : [];
        }

        // Si no se encuentra la revisión o la imagen, devolver un array vacío
        return [];
    }


    // Obtener Imágenes de Contenido según Opción
    public function obtenerImagenesContenido($idContent, $opcion)
    {
        $rutasImg = [];

        if ($opcion == 1) {
            $imagenes = ImagenesContenido::where('contenidos_idcontenidos', $idContent)->get();

            foreach ($imagenes as $imgEspecifica) {
                $rutasImg = array_merge($rutasImg, $this->obtenerRutaImagen($imgEspecifica->revisionImagenes_idrevisionImagenescol));
            }
        } elseif ($opcion == 2) {
            $rutasImg = $this->obtenerRutaImagen($idContent);
        }

        return $rutasImg;
    }

    public function procesarActividades($actividades, $reportado)
    {
        $resultados = [
            'comentarios' => [],
            'contenidos' => [],
            'perfil' => [],
        ];

        foreach ($actividades as $actividad) {
            $actividadId = $actividad->idActividad;
            $tipoActividad = $actividad->tipoActividad_idtipoActividad;

            // Si la actividad es del tipo 1 (Perfil)
            if ($tipoActividad == 1) {
                $resultados['perfil'][] = [
                    'id' => $actividadId,
                    'reportado' => $reportado,
                    'tipoActividad' => $tipoActividad,
                ];
            } elseif ($tipoActividad == 2) { // Comentarios
                $comentarios = Comentarios::where('Actividad_idActividad', $actividadId)->get();

                foreach ($comentarios as $comentario) {
                    $contenido = Contenidos::find($comentario->contenidos_idcontenidos);
                    $rutaImagen = $this->obtenerImagenesContenido($comentario->revisionImagenes_idrevisionImagenescol, 2);

                    $resultados['comentarios'][] = [
                        'idComentario' => $comentario->idcomentarios,
                        'fechaComent' => $comentario->fechaComent,
                        'descripcion' => $comentario->descripcion,
                        'tituloContenido' => $contenido ? $contenido->titulo : null,
                        'id' => $contenido ? $contenido->idcontenidos : null,
                        'reportado' => $reportado,
                        'rutaImagen' => $rutaImagen,
                        'tipoActividad' => $tipoActividad,
                    ];
                }
            } elseif ($tipoActividad == 3) { // Contenidos
                $contenidos = Contenidos::where('Actividad_idActividad', $actividadId)->get();

                foreach ($contenidos as $contenido) {
                    $rutaImagen = $this->obtenerImagenesContenido($contenido->idcontenidos, 1);

                    $resultados['contenidos'][] = [
                        'id' => $contenido->idcontenidos,
                        'fechaComent' => $contenido->fechaSubida,
                        'titulo' => $contenido->titulo,
                        'descripcion' => $contenido->descripcion,
                        'reportado' => $reportado,
                        'rutaImagen' => $rutaImagen,
                        'tipoActividad' => $tipoActividad,
                    ];
                }
            }
        }

        return $resultados;
    }

    // Redirigir a manejoReporte
    public function manejoreporte($id)
    {
        $usuario = Usuario::find($id);
        $datosPersonales = $usuario->datosPersonales;
        $imagen = $this->buscarImagen($id);

        // Obtener todas las actividades del usuario
        $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

        // Separar actividades reportadas y no reportadas
        #Filter con fn: Filtra elementos de una colección que cumplan con una condición específica definida por una función.
        #Diff: Devuelve los elementos que están en una colección pero no en otra, ayudando a identificar diferencias entre dos conjuntos de datos.
        $reportadas = $actividades->filter(fn($act) => Interacciones::where('actividad_idActividad', $act->idActividad)->where('reporte', '>', 0)->exists());
        $noReportadas = $actividades->diff($reportadas);

        // Procesar y organizar actividades
        $actividadesReportadas = $this->procesarActividades($reportadas, true);
        $actividadesNoReportadas = $this->procesarActividades($noReportadas, false);

        // Calcular totales
        $totalNoReportadas = count($actividadesNoReportadas['comentarios']) + count($actividadesNoReportadas['contenidos']);
        $totalReportadas = count($actividadesReportadas['comentarios']) + count($actividadesReportadas['contenidos']);

        // Verificar si hubo reportes del perfil
        $perfilReportado = count($actividadesReportadas['perfil']) > 0;

        return view('profile.manejoreporte', compact(
            'usuario',
            'datosPersonales',
            'imagen',
            'actividades',
            'actividadesReportadas',
            'actividadesNoReportadas',
            'totalNoReportadas',
            'totalReportadas',
            'perfilReportado'

        ));
    }
}

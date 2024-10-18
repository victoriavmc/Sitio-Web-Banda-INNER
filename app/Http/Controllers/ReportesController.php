<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\Imagenes;
use App\Models\RevisionImagenes;
use App\Models\Usuario;
use App\Models\Actividad;
use App\Models\Comentarios;
use App\Models\DatosPersonales;
use App\Models\HistorialUsuario;
use App\Models\Interacciones;
use App\Models\ImagenesContenido;
use App\Models\Reportes;
use App\Models\Motivos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    // Actividades Obtencion
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
    #Eliminar Revision e Imagenes
    private function eliminarImagenYRevision($revisionImagenId)
    {
        if ($revisionImagenId) {
            $revisionImagen = RevisionImagenes::find($revisionImagenId);
            if ($revisionImagen) {
                // Eliminar la revisión de la imagen
                $revisionImagen->delete();

                // Eliminar la imagen asociada
                if ($revisionImagen->imagenes_idimagenes) {
                    $imagen = Imagenes::find($revisionImagen->imagenes_idimagenes);
                    if ($imagen) {
                        // Eliminar la imagen del almacenamiento
                        Storage::disk('public')->delete($imagen->subidaImg);
                        // Eliminar la imagen de la base de datos
                        $imagen->delete();
                    }
                }
            }
        }
    }
    //Obtener que reportaron
    public function procesarReportes($actividades)
    {
        $resultados = []; // Almacenar resultados agrupados por usuario

        foreach ($actividades as $actividad) {
            $actividadId = $actividad->idActividad;
            $tipoActividad = $actividad->tipoActividad_idtipoActividad;

            // Obtener los usuarios que reportaron esta actividad
            $usuariosReportaron = Interacciones::where('actividad_idActividad', $actividadId)
                ->where('reporte', '>', 0)
                ->with('usuario') // Cargar el usuario que hizo el reporte
                ->get();

            foreach ($usuariosReportaron as $usuario) {

                $reporto = $usuario->usuarios_idusuarios;
                $imagen = $this->buscarImagen($reporto);
                $nombreUsuario = $usuario->usuario->usuarioUser;

                if (!isset($resultados[$reporto])) {
                    $resultados[$reporto] = [
                        'id' => $reporto,
                        'nombre' => $nombreUsuario,
                        'imagen' => $imagen,
                        'reportes' => [],
                    ];
                }

                // Añadir reporte a la lista del usuario
                if ($tipoActividad == 1) { // Perfil
                    $resultados[$reporto]['reportes'][] = 'El Perfil';
                } elseif ($tipoActividad == 2) { // Comentarios
                    $contenido = Comentarios::where('Actividad_idActividad', $actividadId)->first();
                    $idContenido = $contenido->contenidos_idcontenidos;
                    $tituloComentario = Contenidos::where('idcontenidos', $idContenido)->first();
                    $tituloPublicacion = $tituloComentario->titulo;
                    $resultados[$reporto]['reportes'][] = "El Comentario de la publicación \"$tituloPublicacion\"";
                } elseif ($tipoActividad == 3) { // Contenidos
                    $contenido = Contenidos::where('Actividad_idActividad', $actividadId)->first();
                    $tituloPublicacion = $contenido ? $contenido->titulo : 'Publicación desconocida';
                    $resultados[$reporto]['reportes'][] = "La Publicación \"$tituloPublicacion\"";
                }
            }
        }

        return $resultados;
    }

    private function prepararDatosReporte($id)
    {
        $usuario = Usuario::find($id);
        $datosPersonales = $usuario->datosPersonales;
        $imagen = $this->buscarImagen($id);

        // Obtener todas las actividades del usuario
        $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

        // Separar actividades reportadas y no reportadas
        $reportadas = $actividades->filter(fn($act) => Interacciones::where('actividad_idActividad', $act->idActividad)->where('reporte', '>', 0)->exists());
        $noReportadas = $actividades->diff($reportadas);

        // Procesar y organizar actividades
        $actividadesReportadas = $this->procesarActividades($reportadas, true);
        $actividadesNoReportadas = $this->procesarActividades($noReportadas, false);

        // Datos de quienes reportaron
        $quienesReportaron = $this->procesarReportes($reportadas);

        // Calcular totales
        $totalNoReportadas = count($actividadesNoReportadas['comentarios']) + count($actividadesNoReportadas['contenidos']);
        $totalReportadas = count($actividadesReportadas['comentarios']) + count($actividadesReportadas['contenidos']);

        // Verificar si hubo reportes del perfil
        $perfilReportado = count($actividadesReportadas['perfil']) > 0;

        return [
            'usuario' => $usuario,
            'datosPersonales' => $datosPersonales,
            'imagen' => $imagen,
            'actividades' => $actividades,
            'actividadesReportadas' => $actividadesReportadas,
            'actividadesNoReportadas' => $actividadesNoReportadas,
            'totalNoReportadas' => $totalNoReportadas,
            'totalReportadas' => $totalReportadas,
            'perfilReportado' => $perfilReportado,
            'quienesReportaron' => $quienesReportaron
        ];
    }

    // Redirigir a manejoReporte
    public function manejoreporte($id)
    {
        $data = $this->prepararDatosReporte($id);
        return view('profile.manejoreporte', $data);
    }

    // Redirigir a vistaDecideReporte
    public function vistaDecideReporte($id)
    {
        $motivos = Motivos::get();

        $data = $this->prepararDatosReporte($id);
        $rolusuario = Auth::user()->rol_idrol;

        if ($rolusuario === 1) {
            return view('profile.vistaDecideReporte', compact('data', 'motivos'));
        } else {
            return view('inicio');
        }
    }

    #ELiminiar Imagen Logica
    public function eliminarImagenLogica($userId)
    {
        // Verificar si existe una foto asociada al usuario
        $existeFoto = RevisionImagenes::where('usuarios_idusuarios', $userId)
            ->where('tipoDeFoto_idtipoDeFoto', 1)
            ->first();

        if ($existeFoto != null) {
            // Obtener la imagen asociada a la revisión de imagen
            $imagenAnterior = Imagenes::find($existeFoto->imagenes_idimagenes);

            // Eliminar la entrada de revisión de imagen
            $existeFoto->delete();

            // Verificar si la imagen existe en el almacenamiento Imagen y eliminarla
            if ($imagenAnterior && Storage::exists($imagenAnterior->subidaImg)) {
                Storage::delete($imagenAnterior->subidaImg);
            }

            // Eliminar la entrada de la imagen
            $imagenAnterior->delete();
            return True;
        } else {
            return False;
        }
    }
    #Admin decide que hacer con el reportado
    public function decideReportes(Request $request)
    {
        // Obtengo el usuario que fue reportado
        $idReportado = $request->idusuario;

        // Obtengo decision del admin
        $decision = $request->decision;

        switch ($decision) {
            case 0:
                // En caso de que el reporte sea falso, eliminar el reporte
                $reporte = Reportes::where('usuarios_idusuarios', $idReportado)->first();
                if ($reporte) {
                    $reporte->delete();
                }

                // Obtener todas las actividades creadas por el usuario
                $actividades = Actividad::where('usuarios_idusuarios', $idReportado)->get();

                foreach ($actividades as $actividad) {
                    $idact = $actividad->idActividad;

                    // Interacciones de la gente ante esa actividad
                    $interacciones = Interacciones::where('actividades_idactividad', $idact)->get();
                    foreach ($interacciones as $interaccion) {
                        // Si la interacción es solo un reporte (reporte === 1 y me gusta o no me gusta === 0)
                        if ($interaccion->reporte === 1 && $interaccion->megusta === 0 && $interaccion->nomegusta === 0) {
                            // Eliminar la interacción
                            $interaccion->delete();
                        } else {
                            // Actualizar el reporte a 0
                            $interaccion->reporte = 0;
                            $interaccion->save();
                        }
                    }
                }

                return redirect()->back()->with('alertReporte', [
                    'type' => 'Success',
                    'message' => 'El reporte y las actividades han sido eliminados correctamente.',
                ]);
                break;
            case 1:
                #En caso que el reporte sea necesario pero lo suspendemos la cuenta segun un tiempo que defina el administardor, entro a la tabla historialUsuario y desactivamos por tiempo definido
                $reporte = Reportes::where('usuarios_idusuarios', $idReportado)->first();
                if ($reporte) {
                    $reporte->motivos = $request->motivo; //array
                    $reporte->save();
                }

                // Obtener todas las actividades creadas por el usuario
                $actividades = Actividad::where('usuarios_idusuarios', $idReportado)->get();

                foreach ($actividades as $actividad) {
                    $idact = $actividad->idActividad;

                    // Interacciones de la gente ante esa actividad
                    $interacciones = Interacciones::where('actividades_idactividad', $idact)->get();
                    foreach ($interacciones as $interaccion) {
                        // Si la interacción es solo un reporte (reporte === 1 y me gusta o no me gusta === 0)
                        if ($interaccion->reporte === 1 && $interaccion->megusta === 0 && $interaccion->nomegusta === 0) {
                            // Eliminar la interacción
                            $interaccion->delete();
                        } else {
                            // Actualizar el reporte a 0
                            $interaccion->reporte = 0;
                            $interaccion->save();
                        }
                    }
                }

                // En caso que el reporte sea necesario pero lo suspendemos la cuenta
                $duracionSuspension = $request->duracion;
                $fechaInica = now(); // Fecha actual
                $fechaFinaliza = now()->addDays($duracionSuspension); // Fecha de finalización

                //idDatospersonales del usuario
                $idDato = DatosPersonales::where('usuarios_idusuarios', $idReportado)->first();

                //Encuentro el historial del Usuario
                $historial = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDato->idDatosPersonales)->first();

                $historial->estado = 'suspendido';
                $historial->fechaInica = $fechaInica;
                $historial->fechaFinaliza = $fechaFinaliza;
                $historial->save();

                // MAIL INFORME DE BANEO Y
                // Enviar correo electrónico al usuario informando que su cuenta ha sido suspendida

                return redirect()->back()->with('alertReporte', [
                    'type' => 'Success',
                    'message' => 'La cuenta ha sido suspendida por ' . $duracionSuspension . ' días.',
                ]);
                break;
            case 2:
                #En caso que el reporte sea necesario pero pesado, entro a la tabla historialUsuario y eliminamos (Eliminacion logica si, usuario, datos personales)
                $reporte = Reportes::where('usuarios_idusuarios', $idReportado)->first();
                if ($reporte) {
                    $reporte->motivos = $request->motivo; //array
                    $reporte->save();
                }

                // Obtener todas las actividades creadas por el usuario
                $actividades = Actividad::where('usuarios_idusuarios', $idReportado)->get();

                foreach ($actividades as $actividad) {
                    $idact = $actividad->idActividad;

                    // Interacciones de la gente ante esa actividad
                    $interacciones = Interacciones::where('actividades_idactividad', $idact)->get();
                    foreach ($interacciones as $interaccion) {
                        // Si la interacción es solo un reporte (reporte === 1 y me gusta o no me gusta === 0)
                        if ($interaccion->reporte === 1 && $interaccion->megusta === 0 && $interaccion->nomegusta === 0) {
                            // Eliminar la interacción
                            $interaccion->delete();
                        } else {
                            // Actualizar el reporte a 0
                            $interaccion->reporte = 0;
                            $interaccion->save();
                        }
                    }
                }

                // En caso que el reporte sea necesario pero le betamos de la pagina.
                $fechaInica = now(); // Fecha actual

                //idDatospersonales del usuario
                $idDato = DatosPersonales::where('usuarios_idusuarios', $idReportado)->first();

                //Encuentro el historial del Usuario
                $historial = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDato->idDatosPersonales)->first();

                $historial->estado = 'Inactivo';
                $historial->eliminacionLogica = 'Si';
                $historial->fechaInica = $fechaInica;
                $historial->save();

                //Actualiza los datos del usuario
                // Borrar la contraseña del usuario de manera segura
                $usuario = Usuario::where('usuarios_idusuarios', $idReportado)->first();
                $usuario->contraseniaUser = null;
                $usuario->usuarioUser = null;
                $usuario->save();

                // Eliminar reportes asociados al usuario
                Reportes::where('usuarios_idusuarios', $idReportado)->delete();

                // Eliminar todas las interacciones que realizó el usuario
                Interacciones::where('usuarios_idusuarios', $idReportado)->delete();

                // Acceder a todas las actividades realizadas por el usuario
                $actividades = Actividad::where('usuarios_idusuarios', $idReportado)->with(['comentarios', 'contenidos'])->get();
                foreach ($actividades as $actividad) {
                    // Eliminar las interacciones de esa actividad
                    Interacciones::where('actividades_idactividad', $actividad->idActividad)->delete();

                    // Eliminar los comentarios
                    foreach ($actividad->comentarios as $comentario) {
                        // Eliminar las interacciones del comentario
                        Interacciones::where('actividades_idactividad', $comentario->Actividad_idActividad)->delete();

                        // Eliminar la imagen asociada al comentario
                        if ($comentario->revisionImagenes_idrevisionImagenescol) {
                            // Eliminar el comentario primero
                            $comentario->delete();
                            // Ahora eliminar la revisión de imagen asociada
                            $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
                        } else {
                            // Solo elimina el comentario si no tiene revisión
                            $comentario->delete();
                        }
                    }

                    // Eliminar los contenidos
                    foreach ($actividad->contenidos as $contenido) {
                        foreach ($contenido->comentarios as $comentario) {
                            Interacciones::where('actividades_idactividad', $comentario->Actividad_idActividad)->delete();
                            $comentario->delete();
                            $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
                            // Eliminar la actividad del comentario de la tabla actividad
                            Actividad::where('idActividad', $comentario->Actividad_idActividad)->delete();
                        }

                        // Eliminar imágenes de contenido y sus revisiones
                        foreach ($contenido->imagenesContenido as $imagenContenido) {
                            $imagenContenido->delete();
                            $this->eliminarImagenYRevision($imagenContenido->revisionImagenes_idrevisionImagenescol);
                        }

                        // Eliminar el contenido
                        $contenido->delete();
                    }

                    // Después de eliminar los contenidos y comentarios, eliminar la actividad
                    $actividad->delete();
                }

                // Borrar la imagen de perfil si tiene
                $eliminado = $this->eliminarImagenLogica($idReportado);

                // Enviar correo electrónico al usuario informando que su cuenta ha sido ELIMINADA MSJ REPORTE

                // Redirigir a la página de panel de usuarios
                return redirect('///')->with('alertBorrar', [
                    'type' => 'Success',
                    'message' => 'Se ha vetado la cuenta con éxito!',
                ]);
        }
    }
}

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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\msjInformeBaneo;
use App\Mail\msjInformeReporte;
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
        $motivos = [];

        $data = $this->prepararDatosReporte($id);
        $reportes = Reportes::where('usuarios_idusuarios', $id)->get();
        foreach ($reportes as $reporte) {
            if ($reporte->motivos_idmotivos != null) {
                $nombreMotivo = $reporte->motivos->descripcion;
                //Guardar el nombre del motivo en un array y el id del reporte
                $motivos[] = [
                    'id' => $reporte->idreportes,
                    'motivo' => $nombreMotivo,
                ];
            }
        }

        return view('profile.manejoreporte', $data, compact('motivos'));
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
                Storage::disk('public')->delete($imagenAnterior->subidaImg);
            }

            // Eliminar la entrada de la imagen
            $imagenAnterior->delete();
            return True;
        } else {
            return False;
        }
    }

    #Admin decide que hacer con el reportado
    public function decideReportes(Request $request, $id)
    {
        // Validacion
        $request->validate([
            'motivo' => [
                'required_if:manejarReporte,1',
                'array',
                'min:1' // Asegura que haya al menos un motivo seleccionado
            ],
            'fechaDesbaneo' => 'required_if:manejarReporte,1|date|after:now',
        ]);

        // Obtengo el usuario reportado
        $usuario = Usuario::find($id);
        $nombreCompleto = $usuario->datospersonales->nombreDP . ' ' . $usuario->datospersonales->apellidoDP;

        // Obtengo el reporte del usuario que fue reportado
        $reporte = Reportes::where('usuarios_idusuarios', $id)->first();

        // Obtengo decision del admin
        $decision = $request->manejarReporte;

        switch ($decision) {
            case "0":
                // En caso de que el reporte sea falso, eliminar el reporte
                if ($reporte) {
                    $reporte->delete();
                }

                // Obtener todas las actividades creadas por el usuario
                $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

                foreach ($actividades as $actividad) {
                    $idact = $actividad->idActividad;

                    // Interacciones de la gente ante esa actividad
                    $interacciones = Interacciones::where('actividad_idActividad', $idact)->get();
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

                    if ($actividad->tipoActividad_idtipoActividad === 1) {
                        $actividad->delete();
                    }
                }

                // Redirigir según el rol del usuario
                $route = ($usuario->rol_idrol === 2) ? 'panel-de-staff' : 'panel-de-usuarios';

                return redirect()->route($route)->with('alertReporte', [
                    'type' => 'Success',
                    'message' => 'El reporte, las actividades y sus interacciones han sido eliminados correctamente.',
                ]);

                break;

            case "1":
                if ($reporte) {
                    // Obtener todos los motivos ya asociados a este usuario
                    $motivosExistentes = Reportes::where('usuarios_idusuarios', $id)
                        ->pluck('motivos_idmotivos')
                        ->toArray();

                    // Filtrar los motivos nuevos (que no están ya asociados)
                    $nuevosMotivos = array_diff($request->motivo, $motivosExistentes);

                    // Si hay motivos nuevos, crear nuevos reportes para cada uno
                    foreach ($nuevosMotivos as $motivo) {
                        $nuevoReporte = new Reportes();
                        $nuevoReporte->motivos_idmotivos = $motivo;
                        $nuevoReporte->usuarios_idusuarios = $id;
                        $nuevoReporte->save();
                    }
                }

                // Obtener todas las actividades del usuario
                $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

                foreach ($actividades as $actividad) {
                    $idact = $actividad->idActividad;

                    // Obtener interacciones de esta actividad
                    $interacciones = Interacciones::where('actividad_idActividad', $idact)->get();

                    foreach ($interacciones as $interaccion) {
                        if ($interaccion->reporte === 1 && $interaccion->megusta === 0 && $interaccion->nomegusta === 0) {
                            // Eliminar interacciones solo de tipo reporte
                            $interaccion->delete();
                        } else {
                            // Si hay otras interacciones, se actualiza reporte a 0
                            $interaccion->reporte = 0;
                            $interaccion->save();
                        }
                    }

                    // Eliminar actividades con tipoActividad_idtipoActividad === 1
                    if ($actividad->tipoActividad_idtipoActividad === 1) {
                        $actividad->delete();
                    }
                }

                // Actualización del historial del usuario
                $idDato = DatosPersonales::where('usuarios_idusuarios', $id)->first();

                if ($idDato) {
                    $historial = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDato->idDatosPersonales)->first();

                    if ($historial) {
                        $historial->estado = 'Suspendido';
                        $historial->fechaInicia = now();
                        $historial->fechaFinaliza = $request->fechaDesbaneo;
                        $historial->save();
                    }
                }

                // Redirigir según el rol del usuario
                $route = ($usuario->rol_idrol === 2) ? 'panel-de-staff' : 'panel-de-usuarios';

                // Enviar un mail
                Mail::to($usuario->correoElectronicoUser)->send(new msjInformeBaneo($usuario->usuarioUser, $request->motivo, now(), $request->fechaDesbaneo));

                return redirect()->route($route)->with('alertReporte', [
                    'type' => 'Success',
                    'message' => 'La cuenta ha sido suspendida hasta la fecha: ' . $request->fechaDesbaneo . ' con éxito!',
                ]);

                break;

            case "2":
                if ($reporte) {
                    // Obtener los motivos ya asociados al usuario
                    $motivosExistentes = Reportes::where('usuarios_idusuarios', $id)
                        ->pluck('motivos_idmotivos')
                        ->toArray();

                    foreach ($request->motivo as $motivo) {
                        if (!in_array($motivo, $motivosExistentes)) {
                            // Crear un nuevo reporte solo si el motivo no existe
                            $nuevoReporte = new Reportes();
                            $nuevoReporte->motivos_idmotivos = $motivo;
                            $nuevoReporte->usuarios_idusuarios = $id;
                            $nuevoReporte->save();
                        }
                    }
                }

                // Obtener todas las actividades creadas por el usuario
                $actividades = Actividad::where('usuarios_idusuarios', $id)->get();

                foreach ($actividades as $actividad) {
                    $idact = $actividad->idActividad;

                    // Interacciones de la gente ante esa actividad
                    $interacciones = Interacciones::where('actividad_idActividad', $idact)->get();
                    foreach ($interacciones as $interaccion) {
                        // Si la interacción es solo un reporte (reporte === 1 y me gusta o no me gusta === 0)
                        if ($interaccion->reporte === 1 && $interaccion->megusta === 0 && $interaccion->nomegusta === 0) {
                            $interaccion->delete();
                        } else {
                            $interaccion->reporte = 0;
                            $interaccion->save();
                        }
                    }

                    if ($actividad->tipoActividad_idtipoActividad === 1) {
                        $actividad->delete();
                    }
                }

                // Actualización del historial del usuario
                $fechaInicia = now();

                $idDato = DatosPersonales::where('usuarios_idusuarios', $id)->first();
                $historial = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDato->idDatosPersonales)->first();

                $historial->estado = 'Baneado';
                $historial->eliminacionLogica = 'Si';
                $historial->fechaInicia = $fechaInicia;
                $historial->save();

                // Actualización del usuario
                $usuario = Usuario::find($id);
                $usuario->contraseniaUser = null;
                $usuario->usuarioUser = null;
                $usuario->save();

                // Eliminar reportes e interacciones asociados
                Interacciones::where('usuarios_idusuarios', $id)->delete();

                // Eliminar actividades y contenido relacionado
                $actividades = Actividad::where('usuarios_idusuarios', $id)->with(['comentarios', 'contenidos'])->get();
                foreach ($actividades as $actividad) {
                    Interacciones::where('actividad_idActividad', $actividad->idActividad)->delete();

                    foreach ($actividad->comentarios as $comentario) {
                        Interacciones::where('actividad_idActividad', $comentario->Actividad_idActividad)->delete();
                        $comentario->delete();
                        $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
                    }

                    foreach ($actividad->contenidos as $contenido) {
                        foreach ($contenido->comentarios as $comentario) {
                            Interacciones::where('actividad_idActividad', $comentario->Actividad_idActividad)->delete();
                            $comentario->delete();
                            $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
                            Actividad::where('idActividad', $comentario->Actividad_idActividad)->delete();
                        }

                        foreach ($contenido->imagenesContenido as $imagenContenido) {
                            $imagenContenido->delete();
                            $this->eliminarImagenYRevision($imagenContenido->revisionImagenes_idrevisionImagenescol);
                        }

                        $contenido->delete();
                    }

                    $actividad->delete();
                }

                // Eliminar imagen de perfil si existe
                $this->eliminarImagenLogica($id);

                // Enviar correo informando la eliminación de la cuenta

                $route = ($usuario->rol_idrol === 2) ? 'panel-de-staff' : 'panel-de-usuarios';

                Mail::to($usuario->correoElectronicoUser)->send(new msjInformeReporte($nombreCompleto));

                return redirect($route)->with('alertReporte', [
                    'type' => 'Success',
                    'message' => 'Se ha baneado a la cuenta de manera permanente con éxito!',
                ]);
                break;
        }
    }

    // Eliminar Motivo del Reporte
    public function eliminarMotivo($id)
    {
        $reporte = Reportes::find($id);
        $idusuarios = $reporte->usuarios_idusuarios;

        $actividades = Actividad::where('usuarios_idusuarios', $idusuarios)->get();

        foreach ($actividades as $actividad) {
            $interacciones = Interacciones::where('actividad_idActividad', $actividad->idActividad)->get();
            foreach ($interacciones as $interaccion) {
                if ($interaccion->reporte === 1 && $interaccion->megusta === 0 && $interaccion->nomegusta === 0) {
                    $interaccion->delete();
                } else {
                    $interaccion->reporte = 0;
                    $interaccion->save();
                }
            }
        }

        if ($reporte) {
            $reporte->delete();
            return redirect()->back()->with('alertReporte', [
                'type' => 'Success',
                'message' => 'El motivo del reporte ha sido eliminado correctamente.',
            ]);
        }

        return redirect()->back()->with('alertReporte', [
            'type' => 'Danger',
            'message' => 'No se pudo eliminar el motivo del reporte.',
        ]);
    }

    // CRUD Motivos

    // Crear motivos
    public function crearMotivo(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:motivos,descripcion|min:4',
        ]);

        $motivo = new Motivos();
        $motivo->descripcion = $request->descripcion;
        $motivo->save();

        return redirect()->back()->with('alertMotivo', [
            'type' => 'Success',
            'message' => 'El motivo ha sido creado correctamente.',
        ]);
    }

    // Editar Motivos
    public function modificarMotivo(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|min:4',
        ]);

        $motivo = Motivos::find($id);
        $motivo->descripcion = $request->descripcion;
        $motivo->save();

        return redirect()->back()->with('alertMotivo', [
            'type' => 'Success',
            'message' => 'El motivo ha sido editado correctamente.',
        ]);
    }

    // Eliminar Motivos
    public function eliminarMotivoAdmin($id)
    {
        $motivo = Motivos::find($id);

        if ($motivo) {
            $motivo->delete();
            return redirect()->back()->with('alertMotivo', [
                'type' => 'Success',
                'message' => 'El motivo ha sido eliminado correctamente.',
            ]);
        }

        return redirect()->back()->with('alertMotivo', [
            'type' => 'Danger',
            'message' => 'No se pudo eliminar el motivo.',
        ]);
    }
}

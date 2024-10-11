<?php

namespace App\Http\Controllers;

#Clases
use App\Models\Actividad;
use App\Models\Contenidos;
use App\Models\DatosPersonales;
use App\Models\Imagenes;
use App\Models\Paisnacimiento;
use App\Models\RevisionImagenes;
use App\Models\Usuario;
use App\Models\Reportes;
use App\Models\Comentarios;
use App\Models\HistorialUsuario;
use App\Models\Interacciones;

#Mails
use App\Mail\msjBajaCuenta;
use App\Mail\msjCambios;
use App\Mail\msjReportaron;
use App\Mail\msjReporto;
#Aparte
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PerfilController extends Controller
{
    public $datos;
    public $pais;
    public $paises;
    public $rol;
    public $email;
    public $imagenPerfil;
    public $imagenExistePerfilEspecifico;

    # Identifico el usuario
    public function identificaUsername()
    {
        $usuario = Auth::user();
        $usuario = Usuario::where('usuarioUser', $usuario->usuarioUser)->first();

        // Verifico si el usuario existe antes de buscar la imagen
        if ($usuario) {
            // Concatenar nombre y apellido
            $nombreApellido = $usuario->datospersonales->nombreDP . ' ' . $usuario->datospersonales->apellidoDP;
            $imagen = $this->buscarImagen($usuario->idusuarios); // Pasamos el ID del usuario
            $usuario->imagenPerfil = $imagen; // Añadimos la imagen al objeto usuario
            $usuario->nombreApellido = $nombreApellido; // Añadir nombre y apellido al objeto usuario
        }

        return $usuario; // Asegúrate de retornar el objeto usuario
    }

    # Envio a la vista PROPIA
    public function perfil()
    {
        // Identifica al usuario
        $usuario = $this->identificaUsername(); // Aquí usuario ya contiene la imagen

        // Comprobar si el usuario existe
        if (!$usuario) {
            // Redirigir o manejar el caso en que no se encuentra el usuario
            return redirect()->route('login')->with('error', 'Usuario no encontrado.');
        }

        // Establecer un valor por defecto para la imagen de perfil si no se encuentra
        $imagenPerfil = $usuario->imagenPerfil; // Cambiar por la ruta de una imagen por defecto

        // Obtener el nombre y apellido
        $nombreApellido = $usuario->nombreApellido; // Obtener el nombre y apellido del objeto usuario

        // Llama a la función para obtener los comentarios relacionados con publicaciones
        $comentariosConPublicacion = $this->obtenerComentariosConPublicacion($usuario->idusuarios);

        $publicaciones = $this->publicaciones($usuario->idusuarios);

        // Retornar los datos a la vista
        return view('profile.perfil', compact('usuario', 'imagenPerfil', 'nombreApellido', 'comentariosConPublicacion', 'publicaciones'));
    }


    #Envio a la vista los datos de Perfil (Datos Cargados Texto)
    public function modificarPerfil()
    {
        // Obtener el usuario autenticado
        $usuario = $this->identificaUsername();

        // Obtener el correo electrónico del usuario
        $this->email = $usuario->correoElectronicoUser;

        // Obtener todos los países de nacimiento
        $this->paises = Paisnacimiento::get();

        // Obtener el ID del usuario y el rol del usuario
        $idUsuario = $usuario->idusuarios;
        $this->rol = $usuario->rol_idrol;

        // Obtener los datos personales del usuario
        $this->datos = DatosPersonales::where('usuarios_idusuarios', $idUsuario)->first();

        // Obtener el país de nacimiento del usuario
        $idPaisNacimientoDP = $this->datos->PaisNacimiento_idPaisNacimiento;
        $this->pais = Paisnacimiento::find($idPaisNacimientoDP);

        // Enviar los datos del perfil a la vista 'modificarPerfil'
        return response()
            ->view('profile.modificarPerfil', [
                'datos' => $this->datos,
                'pais' => $this->pais,
                'paises' => $this->paises,
                'rol' => $this->rol,
                'email' => $this->email,
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    # Modifico los datos personales del usuario
    public function editarInfoCuenta(Request $request)
    {
        // Validar los campos enviados en el request
        $request->validate([
            'nombre' => 'required|string|min:3|max:64',
            'apellido' => 'required|string|min:3|max:64',
            'confirmarContraseña' => 'required|min:8|max:16',
        ]);

        // Obtener el usuario autenticado y sus datos personales
        $usuario = Auth::user();
        $datoBD = DatosPersonales::where('usuarios_idusuarios', $usuario->idusuarios)->firstOrFail();

        // Verificar si la contraseña ingresada coincide con la actual
        if (Hash::check($request->confirmarContraseña, $usuario->contraseniaUser)) {
            // Actualizar los datos personales del usuario
            $datoBD->update([
                'nombreDP' => $request->nombre,
                'apellidoDP' => $request->apellido,
                'fechaNacimiento' => $request->fechaNacimiento,
                'PaisNacimiento_idPaisNacimiento' => $request->paisNacimiento,
            ]);

            // Enviar correo de notificación sobre los cambios realizados
            Mail::to($usuario->correoElectronicoUser)->send(new msjCambios($datoBD->nombreDP));

            // Retornar éxito
            return redirect()->back()->with('alertCambios', [
                'type' => 'Success',
                'message' => 'Sus datos han sido cambiados con éxito.',
            ]);
        } else {
            // Retornar error si la contraseña es incorrecta
            return redirect()->back()->withErrors(['confirmarContraseña' => 'La contraseña es incorrecta.']);
        }
    }

    # Modifico la contraseña del usuario
    public function editarContrasenia(Request $request)
    {
        // Validar la contraseña actual y la nueva
        $request->validate([
            'contraseñaActual' => 'required|min:8|max:16|current_password',
            'nuevaContraseña' => 'required|min:8|max:16|different:contraseñaActual|confirmed',
        ]);

        // Obtener el usuario autenticado y sus datos personales
        $usuarioBD = $this->identificaUsername();

        $datoBD = DatosPersonales::where('usuarios_idusuarios', $usuarioBD->idusuarios)->first();

        // Actualizar la nueva contraseña
        $usuarioBD->contraseniaUser = Hash::make($request->nuevaContraseña);
        $usuarioBD->save();

        // Enviar correo de notificación sobre los cambios realizados
        Mail::to($usuarioBD->correoElectronicoUser)->send(new msjCambios($datoBD->nombreDP));

        // Retornar éxito
        return redirect()->back()->with('alertCambios', [
            'type' => 'Success',
            'message' => 'Su contraseña ha sido cambiada con éxito.',
        ]);
    }

    # Modifico el correo electrónico del usuario
    public function editarCorreo(Request $request)
    {
        // Validar el correo actual, el nuevo correo y la contraseña
        $request->validate([
            'correoActual' => 'required|email',
            'correoNuevo' => 'required|email|different:correoActual',
            'passwordCorreo' => 'required|min:8|max:16',
        ]);

        // Obtener el usuario autenticado y sus datos personales
        $usuarioBD = $this->identificaUsername();

        $datoBD = DatosPersonales::where('usuarios_idusuarios', $usuarioBD->idusuarios)->first();

        // Verificar si la contraseña es correcta
        if (Hash::check($request->passwordCorreo, $usuarioBD->contraseniaUser)) {
            // Verificar si el correo actual coincide con el registrado
            if ($usuarioBD->correoElectronicoUser === $request->correoActual) {
                // Actualizar el correo electrónico
                $usuarioBD->update([
                    'correoElectronicoUser' => $request->correoNuevo,
                ]);

                // Enviar correo de notificación sobre los cambios realizados
                Mail::to($request->correoNuevo)->send(new msjCambios($datoBD->nombreDP));

                // Retornar éxito
                return redirect()->back()->with('alertCambios', [
                    'type' => 'Success',
                    'message' => 'Su correo electrónico ha sido actualizado con éxito.',
                ]);
            } else {
                // Retornar error si el correo actual no coincide
                return redirect()->back()->withErrors(['correoActual' => 'El correo actual no coincide con el registrado.']);
            }
        } else {
            // Retornar error si la contraseña es incorrecta
            return redirect()->back()->withErrors(['passwordCorreo' => 'La contraseña es incorrecta.']);
        }
    }

    # INGRESA IMAGENES A REGISTRO IMAGENES
    public function cargaImagenTipo1($idUser, $idImg)
    {
        $revisionImg = new RevisionImagenes();
        $revisionImg->usuarios_idusuarios = $idUser;
        $revisionImg->imagenes_idimagenes = $idImg;
        $revisionImg->tipoDeFoto_idtipoDeFoto = 1;
        $revisionImg->save();
    }

    #Modificar Imagen
    public function cambiarImagen(Request $request)
    {
        // Validar la imagen
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:512',
        ]);

        $usuarioBD = $this->identificaUsername();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('img', 'public');
            $imagen = new Imagenes();
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
            $imagen->contenidoDescargable = 'No';
            $imagen->save();

            $userId = $usuarioBD->idusuarios;
            $idFoto = $imagen->idimagenes;

            $existeFoto = RevisionImagenes::where('usuarios_idusuarios', $userId)->where('tipoDeFoto_idtipoDeFoto', 1)->first();

            if ($existeFoto != null) {
                // Obtener el registro de la imagen anterior
                $imagenAnterior = Imagenes::find($existeFoto->imagenes_idimagenes);

                // Eliminar el registro de la revisión anterior
                $existeFoto->delete(); // IMPORTANTE: Eliminar primero la revisión

                // Eliminar el archivo del almacenamiento y el registro de la imagen anterior
                if ($imagenAnterior && Storage::exists($imagenAnterior->subidaImg)) {
                    Storage::delete($imagenAnterior->subidaImg);
                }

                // Ahora eliminar el registro de la imagen anterior
                $imagenAnterior->delete();
            }

            $this->cargaImagenTipo1($userId, $idFoto);

            // Redirigir con la URL de la imagen y una alerta de éxito
            return redirect()->back()->with([
                'alertCambios' => [
                    'type' => 'Success',
                    'message' => 'La imagen se ha subido correctamente.',
                ],
            ]);
        }
        // Redirigir con una alerta de error si no se ha subido ninguna imagen
        return redirect()->back()->with([
            'alertCambios' => [
                'type' => 'Error',
                'message' => 'Hubo un problema con la carga de la imagen.',
            ]
        ]);
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

    #Eliminar Imagen
    public function eliminarImagen()
    {
        // Identificar al usuario actual
        $usuarioBD = $this->identificaUsername();
        $userId = $usuarioBD->idusuarios;

        $modelo = $this->eliminarImagenLogica($userId);

        if ($modelo) {
            // Redirigir con un mensaje de éxito
            return redirect()->back()->with([
                'alertCambios' => [
                    'type' => 'Success',
                    'message' => 'La imagen se ha eliminado correctamente.',
                ]
            ]);
        }
    }

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

    #Si alguien reporta una cuenta
    public function reportarCuenta(Request $request)
    {
        // Guardo el id del usuario que reporta, para enviar al admin quien reporto.
        $idUser = $request->idusuarios;

        $userReportado = $request->usuarios_idusuarios;

        $reporte = Reportes::where('usuarios_idusuarios', $userReportado)->first();

        $aumentoReporte = $reporte->reportes;
        $aumentoReporte++;
        $reporte->reportes = $aumentoReporte;
        $reporte->save();

        // ACA HAY QUE HACER LOGICA PARA ENVIAR 2 MAILS.

        // UNO DONDE HIZO EL REPORTE A LA CUENTA X.
        Mail::to($request->email)->send(new msjReporto(ucwords($request->nombre), $request->genero));

        // OTRO ENVIANDO AL ADMIN, QUIEN HIZO UN REPORTE A LA CUENTA Y.
        Mail::to($request->email)->send(new msjReportaron(ucwords($request->nombre), $request->genero));
    }

    #Mostramos Los comentarios si tiene el usuario
    public function obtenerComentariosConPublicacion($data)
    {
        // Obtengo las actividades del usuario
        $actividades = Actividad::where('usuarios_idusuarios', $data)->get();

        // Inicializo un array para almacenar los datos procesados
        $comentariosArray = [];

        // Recorro las actividades para obtener los comentarios correspondientes
        foreach ($actividades as $actividad) {
            // Obtengo los comentarios de la actividad
            $comentarios = Comentarios::where('Actividad_idActividad', $actividad->idActividad)
                ->orderBy('fechaComent', 'desc')
                ->get();

            foreach ($comentarios as $comentario) {
                // Limitar la descripción a 20 palabras
                $comentario->descripcion = Str::words($comentario->descripcion, 20);
                $fechaComentario = $comentario->fechaComent;

                // Relacionar el comentario con su publicación
                $publicacion = Contenidos::find($comentario->contenidos_idcontenidos);

                if ($publicacion) {
                    $idPublicacion = $publicacion->idcontenidos;
                    $publicacionComentada = $publicacion->titulo;
                    $publicacionSubida = $publicacion->fechaSubida;

                    // Almacenar los datos en el array
                    $comentariosArray[] = [
                        'idPublicacion' => $idPublicacion,
                        'descripcion' => $comentario->descripcion,
                        'fechaComentario' => $fechaComentario,
                        'publicacionTitulo' => $publicacionComentada,
                        'publicacionFechaSubida' => $publicacionSubida
                    ];
                }
            }
        }

        // Retorna el array con todos los comentarios y sus publicaciones
        return $comentariosArray;
    }


    #Mostramos Las publicaciones si tiene el usuario
    public function publicaciones($userId)
    {
        // Obtengo las actividades del usuario
        $actividades = Actividad::where('usuarios_idusuarios', $userId)->get();

        // Inicializo un array para almacenar los datos procesados
        $contenidosArray = [];

        // Recorro las actividades para obtener los contenidos correspondientes
        foreach ($actividades as $actividad) {
            // Obtengo los contenidos de la actividad
            $contenidos = Contenidos::where('Actividad_idActividad', $actividad->idActividad)->where('tipoContenido_idtipoContenido', 1)
                ->orderBy('fechaSubida', 'desc')
                ->get();

            foreach ($contenidos as $publicacion) {
                // Limitar la descripción a 20 palabras
                $idPublicacion = $publicacion->idcontenidos;
                $publicacionTitulo = $publicacion->titulo;
                $publicacion->descripcion = Str::words($publicacion->descripcion, 25);
                $fechaPublicacion = $publicacion->fechaSubida;

                // Almacenar los datos en el array
                $contenidosArray[] = [
                    'idPublicacion' => $idPublicacion,
                    'publicacionTitulo' => $publicacionTitulo,
                    'descripcion' => $publicacion->descripcion,
                    'fechaPublicacion' => $fechaPublicacion,
                ];
            }
        }

        // Retorna el array con todos los contenidos y sus publicaciones
        return $contenidosArray;
    }

    #Logica de perfil ajeno
    public function verPerfilAjeno($id)
    {
        // Identifico el usuario ajeno
        $otroUsuario = Usuario::find($id); // Use the parameter directly

        // Verifico si el usuario existe
        if ($otroUsuario) {

            // Obtengo el nombre de usuario
            $usuarioUser = $otroUsuario->usuarioUser;
            $nombreApellido = $otroUsuario->datospersonales->nombreDP . ' ' . $otroUsuario->datospersonales->apellidoDP;

            // Obtengo el rol del usuario

            $tipoRol = $otroUsuario->rol->rol;

            if ($tipoRol == 'Staff') {
                $nombreRol = $otroUsuario->staffExtra->tipoStaff->nombreStaff ?? ' ';
            } else {
                $nombreRol = ' ';
            }

            // Busco la imagen de perfil
            $imagenPerfil = $this->buscarImagen($otroUsuario->idusuarios);

            $comentariosConPublicacion = $this->obtenerComentariosConPublicacion($id);
            $publicaciones = $this->publicaciones($id);

            // Retorna la vista con la información del usuario
            return view('profile.verPerfilAjeno', [
                'usuarioUser' => $usuarioUser,
                'nombreApellido' => $nombreApellido,
                'tipoRol' => $tipoRol,
                'nombreRol' => $nombreRol,
                'imagen' => $imagenPerfil,
                'comentariosConPublicacion' => $comentariosConPublicacion,
                'publicaciones' => $publicaciones,
            ]);
        } else {
            // Manejo de error si el usuario no se encuentra
            return redirect()->route('some.route')->with('error', 'Usuario no encontrado.');
        }
    }

    #Admin decide que hacer con el reportado
    public function reportar(Request $request)
    {
        // Obtengo el usuario que fue reportado
        $idReportado = $request->idusuario;

        // Obtengo decision del admin
        $decision = $request->decision;

        switch ($decision) {
            case 0:
                #En caso que el reporte sea falso, disminuyo el reporte
                $reporte = Reportes::where('usuarios_idusuarios', $idReportado)->first();
                $disminuyoReporte = $reporte->reportes;
                $disminuyoReporte--;
                $reporte->reportes = $disminuyoReporte;
                break;
            case 1:
                #En caso que el reporte sea necesario pero zzz, entro a la tabla historialUsuario y desactivamos por tiempo definido
                break;
            case 2:
                #En caso que el reporte sea necesario pero hard, entro a la tabla historialUsuario y eliminamos (Eliminacion logica si, usuario, datos personales)
                break;
        }
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
    #ELIMINAR CUENTA EN CASCADA
    #CUANDO ELIMINA LA CUENTA, DEBE ELIMINAR TODO LO RELACIONADO AL USUARIO MENOS LA PARTE LOGICA QUE ES USUARIO, DATOS PERSONALES Y ANOTARLO EN HISTORIALUSUARIOS 
    public function eliminarCuenta()
    {
        // Identifica al usuario
        $usuario = $this->identificaUsername();

        $id = $usuario->idusuarios;

        // Encontrar al usuario
        $usuario = Usuario::find($id);

        // Verificar si el usuario tiene reportes asociados (aquí asumo que tienes un atributo 'reportes')
        $tieneReportes = Reportes::where('usuarios_idusuarios', $id)->value('reportes');

        // Relaciono a su usuario con datos personales
        $datospersonales = DatosPersonales::where('usuarios_idusuarios', $id)->first();

        if ($tieneReportes === 0) {
            // Verificamos si existen los datos personales
            if ($datospersonales) {
                // Actualizo el Historial Usuario
                $historial = HistorialUsuario::where('datospersonales_idDatosPersonales', $datospersonales->idDatosPersonales)->first();
                if ($historial) {
                    $historial->estado = "Inactivo";
                    $historial->eliminacionLogica = 'Si';
                    $historial->save();
                }

                // Aquí deberías borrar la contraseña del usuario de manera segura
                $usuario->contraseniaUser = null;
                $usuario->save();
            }

            // Si no hay reportes, eliminamos al usuario de la tabla
            Reportes::where('usuarios_idusuarios', $id)->delete();


            // Elimino todas las interacciones que realizó el usuario
            Interacciones::where('usuarios_idusuarios', $id)->delete();

            // Accedo a todas las actividades realizadas por el usuario
            $actividades = Actividad::where('usuarios_idusuarios', $id)->with(['comentarios', 'contenidos'])->get();
            foreach ($actividades as $actividad) {
                // Eliminar las interacciones de esa actividad
                Interacciones::where('Actividad_idActividad', $actividad->idActividad)->delete();

                // Eliminar los comentarios
                foreach ($actividad->comentarios as $comentario) {
                    // Eliminar las interacciones del comentario
                    Interacciones::where('Actividad_idActividad', $comentario->Actividad_idActividad)->delete();

                    // Eliminar la imagen asociada al comentario
                    if ($comentario->revisionImagenes_idrevisionImagenescol) {
                        // Eliminar el comentario primero
                        $comentario->delete();
                        // Ahora elimina la revisión de imagen asociada
                        $this->eliminarImagenYRevision($comentario->revisionImagenes_idrevisionImagenescol);
                    } else {
                        // Solo elimina el comentario si no tiene revisión
                        $comentario->delete();
                    }
                }

                // Eliminar los contenidos
                foreach ($actividad->contenidos as $contenido) {
                    foreach ($contenido->comentarios as $comentario) {
                        Interacciones::where('Actividad_idActividad', $comentario->Actividad_idActividad)->delete();
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

            // Borramos la imagen de perfil si tiene
            $eliminado = $this->eliminarImagenLogica($id);

            // Cerrar la sesión del usuario
            Auth::logout();

            // Redirigir a la página de inicio
            return redirect('inicio')->with('alertBorrar', [
                'type' => 'Success',
                'message' => 'Se ha borrado la cuenta con éxito!',
            ]);
        } else {
            ## En caso que presente reportes, debe enviar al administrador una notificacion que revise la cuenta de este
            return redirect()->back()->with('alertBorrar', [
                'type' => 'Error',
                'message' => 'No se puede borrar la cuenta, ya que presenta reportes.
            Se ha enviado una notificación al administrador para que revise la cuenta.',
            ]);
        }
    }
}

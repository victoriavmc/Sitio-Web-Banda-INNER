<?php

namespace App\Http\Controllers;

#Clases
use App\Models\DatosPersonales;
use App\Models\imagenes;
use App\Models\Paisnacimiento;
use App\Models\RevisionImagenes;
use App\Models\Usuario;
use App\Models\Redsocial;
use App\Models\Seguidores;

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

class PerfilController extends Controller
{
    public $datos;
    public $pais;
    public $paises;
    public $rol;
    public $email;
    public $imagenPerfil;
    public $imagenExistePerfilEspecifico;

    #Identifico el usuario
    public function identificaUsername()
    {
        $usuario = Auth::user();
        $usuario = Usuario::where('usuarioUser', $usuario->usuarioUser)->first();
        return $usuario;
    }

    #Envio a la vista
    public function perfil()
    {
        $usuario = $this->identificaUsername();
        return view('profile.perfil', compact('usuario'));
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
            $path = $request->file('imagen')->store('public/img');
            $imagen = new Imagenes();
            $imagen->subidaImg = $path;
            $imagen->fechaSubidaImg = now();
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

    #Eliminar Imagen
    public function eliminarImagen(Request $request)
    {
        // Identificar al usuario actual
        $usuarioBD = $this->identificaUsername();
        $userId = $usuarioBD->idusuarios;

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
    public function buscarImagen(Request $request)
    {
        // Guardo el id del usuario
        $idUser = $request->idusuarios;

        // Ahora busco en la tabla revisionImagenes
        $imagenPerfil = RevisionImagenes::where('usuarios_idusuarios', $idUser)
            ->where('tipodefoto_idtipoDeFoto', 1)
            ->first();

        if ($imagenPerfil) {
            $idImagenP = $imagenPerfil->imagenes_idimagenes;

            // Ahora busco la imagen en la tabla imagenes
            $ubicacionImagen = Imagenes::where('idimagenes', $idImagenP)
                ->first();

            $ubicarImagen = $ubicacionImagen ? $ubicacionImagen->subidaImg : null;
        } else {
            $ubicarImagen = null; // Inicializo la variable
        }

        $this->imagenExistePerfilEspecifico = $ubicarImagen;
    }

    #Si alguien reporta una cuenta
    public function reportarCuenta(Request $request)
    {
        // Guardo el id del usuario que reporta, para enviar al admin quien reporto.
        $idUser = $request->idusuarios;

        $userReportado = $request->usuarios_idusuarios;

        $reporte = Redsocial::where('usuarios_idusuarios', $userReportado)->first();

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
                $reporte = Redsocial::where('usuarios_idusuarios', $idReportado)->first();
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

    #ELIMINAR CUENTA EN CASCADA
    #CUANDO ELIMINA LA CUENTA, DEBE ELIMINAR TODO LO RELACIONADO AL USUARIO MENOS LA PARTE LOGICA QUE ES USUARIO, DATOS PERSONALES Y ANOTARLO EN HISTORIALUSUARIOS 
    public function eliminarCuenta(Request $request) {}
}

<?php

namespace App\Http\Controllers;

#Clases
use App\Models\DatosPersonales;
use App\Models\HistorialUsuario;
use App\Models\Usuario;
use App\Models\RevisionImagenes;

#MAILS
use App\Mail\msjPinOlvido;
use App\Mail\msjRegistro;
use App\Mail\msjRestablecer;

#Aparte
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use illuminate\support\Str;

class LoginController extends Controller
{
    // USUARIO VERIFICA ESTADO
    public function verificarEstado($entradaUsuario)
    {
        // Verificar si el usuario existe en la base de datos por correo electrónico o nombre de usuario
        if (filter_var($entradaUsuario, FILTER_VALIDATE_EMAIL)) {
            $usuarioExistente = Usuario::where('correoElectronicoUser', $entradaUsuario)->first();
        } else {
            $usuarioExistente = Usuario::where('usuarioUser', $entradaUsuario)->first();
        }

        try {
            $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;
        } catch (\Throwable $th) {
            return false;
        }

        $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();

        if (!$historialUsuario) return false;
        return $historialUsuario->estado;
    }

    #REGISTRO
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:16',
            'nombre' => 'required|string|min:3|max:64',
            'apellido' => 'required|string|min:3|max:64',
            'fechaNacimiento' => 'required|date',
            'paisDeNacimiento' => 'required|string',
            'genero' => 'required|string',
            'usuario' => 'required|string|max:255|regex:/^[^@]+$/',
        ]);

        // Verificar estado del usuario
        $usuarioExistente = $this->verificarEstado($request->email);

        switch ($usuarioExistente) {
            case false:
                // Opción 1: Registro normal de un nuevo usuario
                $usuario = new Usuario();
                $dato = new DatosPersonales();

                // Guardar usuario
                $usuario->usuarioUser = $request->usuario;
                $usuario->correoElectronicoUser = $request->email;
                $usuario->contraseniaUser = Hash::make($request->password);
                $usuario->rol_idrol = 4;
                $usuario->save();

                // Guardar datos personales
                $dato->nombreDP = ucwords($request->nombre);
                $dato->apellidoDP = ucwords($request->apellido);
                $dato->fechaNacimiento = $request->fechaNacimiento;
                $dato->PaisNacimiento_idPaisNacimiento = $request->paisDeNacimiento;
                $dato->generoDP = $request->genero;
                $dato->usuarios_idusuarios = $usuario->idusuarios;
                $dato->save();

                // Registrar en HistorialUsuario
                $historial = new HistorialUsuario();
                $historial->datospersonales_idDatosPersonales = $dato->idDatosPersonales;
                $historial->save();

                // Enviar correo de bienvenida
                Mail::to($request->email)->send(new msjRegistro(ucwords($request->nombre), $request->genero));

                return redirect(route('login'))->with('alertRegistro', [
                    'type' => 'Success',
                    'message' => 'Tu registro ha sido completado con éxito! Por favor, revisa tu correo electrónico. Si no ves el correo en tu bandeja de entrada, asegúrate de revisar también la carpeta de spam o correo no deseado.',
                ]);
                break;

            case 'Inactivo':
                // Opción 2: Usuario inactivo (posibilidad de reactivar cuenta)
                $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)->first();

                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();

                $idhistorialUsuario = $historialUsuario->idhistorialusuario;

                // Redirigir a la página de reactivación de cuenta

                // mensaje alerta existe un usuario con ese correo electronico
                return redirect()->route('reactivar-cuenta', ['id' => $idhistorialUsuario])->with('alertRegistro', [
                    'type' => 'Warning',
                    'message' => 'Su cuenta se encuentra Inactiva.',
                ]);
                break;

            case 'Suspendido':
                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();

                return redirect()->route('login')->with('alertRegistro', [
                    'type' => 'Warning',
                    'message' => 'Su usuario ha sido suspendido hasta el dia ' . $historialUsuario->fechaFinaliza . ' , no podrá acceder.',
                ]);
                break;

            case 'Baneado':
                // Opción 3: Usuario baneado
                $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)->first();

                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();
                $idhistorialUsuario = $historialUsuario->idhistorialusuario;

                // Mensaje alerta: el usuario se encuentra baneado.
                return redirect()->route('inicio')
                    ->with('alertBaneo', [
                        'type' => 'warning',
                        'message' => 'Su usuario ha sido baneado, no podrá acceder.',
                    ]);

            default:
                // El usuario existe pero no está inactivo ni baneado (no permitir registro)
                return redirect()->back()->with('alertRegistro', [
                    'type' => 'Warning',
                    'message' => 'Ya existe una cuenta asociada a este correo electrónico.',
                ]);
                break;
        }
    }


    #VERIFICAR CORREO O USUARIO INGRESADO
    public function verificarCorreoUsuario(Request $request)
    {
        // Validar los campos del request
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        // Obtener el valor del campo 'email' del request
        $input = $request->input('email');

        // Inicializar la variable fail como FALSE
        $fail = true;

        // Verificar si el input corresponde a un correo electrónico o a un usario
        $correo = Usuario::where('correoElectronicoUser', $input)->exists();
        $usuario = Usuario::where('usuarioUser', $input)->exists();

        if (!$correo && !$usuario) {
            // Si el correo y el usuario no existen, marcar como fallo
            $fail = false;
        } else {
            // Si existe correo y/o usuario
            $fail = true;
        }
        // Retornar el estado de fail
        return $fail;
    }

    #LOGEARSE
    public function login(Request $request)
    {
        // validar inicio de sesion
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8|max:16',
        ]);

        // LLAMAMOS LA FUNCION ANTERIOR
        $usuario = $this->verificarEstado($request->email);

        switch ($usuario) {
            case false:
                return redirect()->back()->with('alertLogin', [
                    'type' => 'Warning',
                    'message' => 'Este correo y contraseña no coinciden con ningun usuario registrado, ingrese sus datos nuevamente o registrese.',
                ]);
                break;

            case 'Inactivo':
                // Opción 2: Usuario inactivo (posibilidad de reactivar cuenta)
                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)->first();
                } else {
                    $usuarioExistente = Usuario::where('usuarioUser', $request->email)->first();
                }

                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();

                $idhistorialUsuario = $historialUsuario->idhistorialusuario;

                // Redirigir a la página de reactivación de cuenta
                if ($historialUsuario->fechaFinaliza < now()) {
                    return redirect()->route('reactivar-cuenta', ['id' => $idhistorialUsuario])->with('alertRegistro', [
                        'type' => 'Warning',
                        'message' => 'Su cuenta se encuentra Inactiva. Reactivala siguiendo los pasos',
                    ]);
                }
                break;

            case 'Suspendido':

                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)->first();
                } else {
                    $usuarioExistente = Usuario::where('usuarioUser', $request->email)->first();
                }

                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();

                return redirect()->route('login')->with('alertRegistro', [
                    'type' => 'Warning',
                    'message' => 'Su usuario ha sido suspendido hasta el dia ' . $historialUsuario->fechaFinaliza . ' , no podrá acceder.',
                ]);
                break;

            case 'Baneado':
                // Opción 3: Usuario baneado
                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)->first();
                } else {
                    $usuarioExistente = Usuario::where('usuarioUser', $request->email)->first();
                }

                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();
                $idhistorialUsuario = $historialUsuario->idhistorialusuario;

                // Mensaje alerta: el usuario se encuentra baneado.
                return redirect()->route('inicio')
                    ->with('alertBaneo', [
                        'type' => 'Warning',
                        'message' => 'Su usuario ha sido baneado, no podrá acceder.',
                    ]);

            case 'Activo':
                $fail = $this->verificarCorreoUsuario($request);

                if ($fail) {
                    $input = $request->input('email');
                    $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL);

                    // Crear las credenciales con el campo 'password'
                    $credentials = $isEmail
                        ? ['correoElectronicoUser' => $input, 'password' => $request->password]
                        : ['usuarioUser' => $input, 'password' => $request->password];

                    // Intentar iniciar sesión con las credenciales proporcionadas
                    if (Auth::attempt($credentials)) {
                        // Regenerar la sesión para evitar fijación de sesión
                        $request->session()->regenerate();

                        // Redirigir al perfil con un mensaje de éxito si la autenticación fue exitosa
                        return redirect(route('perfil'))->with('alertInicioSesion', [
                            'type' => 'Success',
                            'message' => 'Inicio de sesión exitoso.'
                        ]);
                    } else {
                        // Si las credenciales no son válidas, redirigir de vuelta con un mensaje de error
                        return redirect()->back()->withErrors(['loginError' => 'Usuario o contraseña incorrectos.']);
                    }
                } else {
                    return redirect()->back()->withErrors(['loginError' => 'Usuario o correo electronico incorrectos.']);
                }

                // Redirigir al perfil con un mensaje de éxito si la autenticación fue exitosa
                break;
        }
    }

    #SOLICITAR PIN
    public function solicitarPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,correoElectronicoUser',
        ]);

        $usuario = $this->verificarEstado($request->email);

        switch ($usuario) {
            case false:
                return redirect()->back()->withErrors('email', [
                    'message' => 'Este correo no coinciden con ningun usuario registrado, ingrese nuevamente.',
                ]);
                break;

            case 'Inactivo':
                // Opción 2: Usuario inactivo (posibilidad de reactivar cuenta)
                $pin = Str::random(6);

                // Buscar el usuario en la base de datos por su correo electrónico
                $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)->first();

                // Actualizar el usuario con el nuevo PIN hasheado
                $usuarioExistente->pinOlvidoUser = Hash::make($pin);
                $usuarioExistente->save();

                // Almacenar el correo electrónico en la sesión para uso posterior
                session(['email' => $request->email]);

                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();

                $idhistorialUsuario = $historialUsuario->idhistorialusuario;

                // Enviar un correo electrónico al usuario con el PIN generado
                Mail::to($usuarioExistente->correoElectronicoUser)->send(new msjPinOlvido($pin));

                // Redirigir a la página de reactivación de cuenta
                // mensaje alerta existe un usuario con ese correo electronico
                return redirect(route('comprobarPin', ['id' => $idhistorialUsuario]))->with('alertRestablecer', [
                    'type' => 'Warning',
                    'message' => 'Para reactivar su cuenta, por favor, ingrese el PIN que se le enviará a su correo electrónico. Si no ves el correo en tu bandeja de entrada, asegúrate de revisar también la carpeta de spam o correo no deseado.',
                ]);
                break;

            case 'Activo':
                // Obtener el valor del campo 'email' del request
                $input = $request->input('email');

                // Generar un PIN aleatorio de 6 caracteres
                $pin = Str::random(6);

                // Buscar el usuario en la base de datos por su correo electrónico
                $usuario = Usuario::where('correoElectronicoUser', $input)->first();

                // Actualizar el usuario con el nuevo PIN hasheado
                $usuario->pinOlvidoUser = Hash::make($pin);
                $usuario->save();

                // Almacenar el correo electrónico en la sesión para uso posterior
                session(['email' => $input]);

                // Enviar un correo electrónico al usuario con el PIN generado
                Mail::to($usuario->correoElectronicoUser)->send(new msjPinOlvido($pin));

                // Redirigir al usuario a la página de comprobación de PIN con un mensaje de advertencia
                return redirect(route('comprobarPin'))->with('alertRestablecer', [
                    'type' => 'Warning',
                    'message' => 'Por favor, revisa tu correo electrónico donde se te envió el pin de olvido. Si no ves el correo en tu bandeja de entrada, asegúrate de revisar también la carpeta de spam o correo no deseado.',
                ]);
                break;

            default:
                // Opción 3: Usuario baneado o inactivo
                $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)->first();

                $idDatosPersonales = $usuarioExistente->DatosPersonales->idDatosPersonales;

                $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $idDatosPersonales)->first();
                $idhistorialUsuario = $historialUsuario->idhistorialusuario;

                // Mensaje alerta: el usuario se encuentra baneado.
                return redirect()->route('inicio')
                    ->with('alertBaneo', [
                        'type' => 'Warning',
                        'message' => 'Su usuario ha sido baneado o eliminado, no podrá acceder.',
                    ]);
                break;
        }
    }

    #COMPROBAR PIN
    public function comprobarPin(Request $request)
    {
        // Validar los campos del request
        $request->validate([
            'pinOlvido' => 'required|min:6',
        ]);

        // Obtener el email del usuario de la sesión actual
        $email = session('email');

        // Buscar el usuario en la base de datos cuyo correo electrónico coincida con el email de la sesión
        $usuario = Usuario::where('correoElectronicoUser', $email)->first();

        // Verificar si el usuario existe y si el PIN ingresado coincide con el almacenado en la base de datos
        if ($usuario && Hash::check($request->pinOlvido, $usuario->pinOlvidoUser)) {

            // Si el PIN es correcto, eliminar el PIN de la base de datos (lo pone a null)
            $usuario->pinOlvidoUser = null;
            $usuario->save();

            // Redirigir al usuario a la página de restablecimiento de contraseña
            return redirect(route('restablecer'));
        } else {
            // Si el PIN es incorrecto, redirigir de vuelta y mostrar un mensaje de error
            return redirect()->back()->withErrors(['pinOlvido' => 'El PIN ingresado es incorrecto.']);
        }
    }

    #CERRAR SESION
    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('inicio'))->with('alertLogout', [
            'type' => 'Success',
            'message' => 'Ha cerrado sesión exitosamente',
        ]);
    }

    #RESTABLECER
    public function restablecer(Request $request)
    {
        // Validar que la nueva contraseña esté presente, tenga un mínimo de 8 caracteres y un máximo de 16
        $request->validate([
            'password' => 'required|min:8|max:16',
        ]);

        // Obtener el email del usuario de la sesión actual
        $email = session('email');

        // Buscar el usuario en la base de datos cuyo correo electrónico coincida con el email de la sesión
        $usuario = Usuario::where('correoElectronicoUser', $email)->first();

        // Obtener la contraseña actual del usuario
        try {
            $passwordActual = $usuario->contraseniaUser;
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('alertRestablecer', [
                'type' => 'Danger',
                'message' => 'Error al reestablecer contraseña.'
            ]);
        }

        // Hashear la contraseña actual para poder compararla con la nueva
        $passwordActual = Hash::make($passwordActual);

        // Verificar si la nueva contraseña ingresada coincide con la actual
        if (Hash::check($request->password, $passwordActual)) {
            return redirect()->back()->withErrors(['password' => 'La contraseña debe ser diferente a la actual.']);
        }

        $usuario->contraseniaUser = Hash::make($request->password);
        $usuario->save();

        // Buscar el historial del usuario
        $historialUsuario = HistorialUsuario::where('datospersonales_idDatosPersonales', $usuario->datospersonales->idDatosPersonales)->first();
        $historialUsuario->estado = 'Activo';
        $historialUsuario->save();

        Auth::logout();
        session()->forget('email');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Enviar un correo de confirmación de restablecimiento de contraseña al usuario
        Mail::to($email)->send(new msjRestablecer);

        // Redirigir al usuario a la página de inicio de sesión con un mensaje de éxito
        return redirect(route('login'))->with('alertRestablecer', [
            'type' => 'Success',
            'message' => 'Contraseña restablecida con éxito. Por favor, inicie sesión.'
        ]);
    }

    public function vistaReactivarCuenta($idhistorialUsuario)
    {
        $historialUsuario = HistorialUsuario::find($idhistorialUsuario);
        $revisionImagenes = RevisionImagenes::where('usuarios_idusuarios', $historialUsuario->datospersonales->usuario->idusuarios)->get();

        $fotoDePerfil = null;

        if ($revisionImagenes) {
            foreach ($revisionImagenes as $revision) {
                if ($revision->tipodefoto_idtipoDeFoto === 1) {
                    $fotoDePerfil = $revision->imagenes->subidaImg;
                }
            }
        }

        if ($historialUsuario->estado == 'Inactivo' && $historialUsuario->fechaFinaliza < now()) {
            return view('auth.reactivarCuenta', compact('fotoDePerfil'));
        } else {
            return redirect(route('inicio'));
        }
    }

    public function contacto($id)
    {
        // Fecha hasta el desbaneo del usuario
        $usuario = HistorialUsuario::find($id);

        $fechaFinal = $usuario->fechaFinaliza;

        return view('auth.contacto', compact('fechaFinal'));
    }

    // reactivarCUENTA
    // Opcion 1
    // Ingrese el correo para OP 1 : RECUPERA LA CONTRASEÑA

    // Opcion 2 
    // No teien más el mismo correo, registrar como nuevo usuario
}

<?php

namespace App\Http\Controllers;

#Clases
use App\Models\DatosPersonales;
use App\Models\HistorialUsuario;
use App\Models\Usuario;

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

        // Buscar si el usuario ya existe por correo electrónico o nombre de usuario
        $usuarioExistente = Usuario::where('correoElectronicoUser', $request->email)
            ->orWhere('usuarioUser', $request->usuario)
            ->first();

        if ($usuarioExistente) {
            // Opción 2: Usuario inactivo (posibilidad de reactivar cuenta)
            $datosPersonales = $usuarioExistente->datospersonales;
            $historialUsuario = $datosPersonales ? $datosPersonales->historialusuario : null;

            if ($historialUsuario == 'Inactivo') {
                // Redirigir a la página de reactivación de cuenta
                return redirect(route('reactivar-cuenta'))->with('alert', [
                    'type' => 'warning',
                    'message' => 'Tu cuenta está inactiva. Por favor, sigue los pasos para reactivarla.'
                ]);
            }

            // Opción 3: Usuario baneado
            if ($historialUsuario == 'Baneado') {
                return redirect(route('registro'))->with('alert', [
                    'type' => 'error',
                    'message' => 'No puedes registrarte de nuevo ya que tu cuenta fue baneada.'
                ]);
            }

            // El usuario existe pero no está inactivo ni baneado (no permitir registro)
            return redirect(route('registro'))->with('alert', [
                'type' => 'error',
                'message' => 'El correo electrónico o el nombre de usuario ya están en uso.'
            ]);
        }

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
        // LLAMAMOS LA FUNCION ANTERIOR
        $fail = $this->verificarCorreoUsuario($request);

        if ($fail) {
            // Validar si corresponde el usuario con la contraseña
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
    }

    #SOLICITAR PIN
    public function solicitarPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,correoElectronicoUser',
        ]);

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
        $passwordActual = $usuario->contraseniaUser;

        // Hashear la contraseña actual para poder compararla con la nueva
        $passwordActual = Hash::make($passwordActual);

        // Verificar si la nueva contraseña ingresada coincide con la actual
        if (Hash::check($request->password, $passwordActual)) {
            return redirect()->back()->withErrors(['password' => 'La contraseña debe ser diferente a la actual.']);
        }

        $usuario->contraseniaUser = Hash::make($request->password);
        $usuario->save();

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
}

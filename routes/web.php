<?php

use App\Http\Controllers\applayoutCrontroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\comentariosController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\eventosController;
use App\Http\Controllers\galeriaController;
use App\Http\Controllers\historiaController;
use App\Http\Controllers\inicioController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\musicaController;
use App\Http\Controllers\nosotrosController;
use App\Http\Controllers\noticiasController;
use App\Http\Controllers\panelStaffController;
use App\Http\Controllers\panelUsuariosController;
use App\Http\Controllers\perfilController;
use App\Http\Controllers\publicacionesForoController;
use App\Http\Controllers\redessocialesController;
use App\Http\Controllers\subirImagenController;
use App\Http\Middleware\verificarPost;
use App\Models\Paisnacimiento;
use App\Models\redessociales;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', InicioController::class)
    ->name('inicio');


//----------------------- CARPETA AUTH -----------------------
// ----------------------- Reestablecer -----------------------
Route::view('/solicitarPin', 'auth.SolicitarPin')
    ->name('solicitarPin')->middleware('guest');

Route::view('/comprobarPin', 'auth.comprobarPin')
    ->name('comprobarPin')->middleware('guest');

Route::view('/restablecer', 'auth.restablecer')
    ->name('restablecer')->middleware('guest');

// ----------------------- lOGIN -----------------------
Route::post('/inicia-sesion', [loginController::class, 'login'])
    ->name('inicia-sesion')->middleware('guest');

Route::post('/validar-registro', [loginController::class, 'register'])
    ->name('validar-registro')->middleware('guest');

Route::post('/solicitar-pin', [loginController::class, 'solicitarPin'])
    ->name('solicitar-pin')->middleware('auth');

Route::post('/comprobar-pin', [loginController::class, 'comprobarPin'])
    ->name('comprobar-pin')->middleware('auth');

Route::post('/restablecer-contrasenia', [loginController::class, 'restablecer'])
    ->name('restablecer-contrasenia')->middleware('auth');

Route::get('/logout', [loginController::class, 'logout'])
    ->name('logout');

// Vistas inicio de sesion
Route::view('/login', "auth.login")
    ->name('login')->middleware('guest');

Route::get('/registro', function () {
    $paises = new Paisnacimiento();
    $paises = Paisnacimiento::get();

    return view('auth.registro', compact('paises'));
})->name('registro')->middleware('guest');
//---------------------------------------------------------------

//----------------------- CARPETA PROFILE -----------------------
// ----------------------- Perfil -----------------------
Route::get('/perfil', [perfilController::class, 'perfil'])
    ->name('perfil')->middleware('auth');

Route::get('/modificar-perfil', [perfilController::class, 'modificarPerfil'])
    ->name('modificar-perfil')->middleware('auth');

// ----------------------- Redes -----------------------
Route::get('/modificar-redes', [redessocialesController::class, 'modificarRedes'])
    ->name('modificar-redes')->middleware('auth');

// ----------------------- Perfil POST -----------------------
Route::post('/perfil/editar-datos', [perfilController::class, 'editarInfoCuenta'])
    ->name('editar-datos')->middleware('auth');

Route::post('/perfil/editar-contrasenia', [perfilController::class, 'editarContrasenia'])
    ->name('editar-contrasenia')->middleware('auth');

Route::post('/perfil/editar-correo', [perfilController::class, 'editarCorreo'])
    ->name('editar-correo')->middleware('auth');

Route::post('/cambiar-imagen', [perfilController::class, 'cambiarImagen'])
    ->name('cambiar-imagen')->middleware('auth');

Route::post('/eliminar-imagen', [perfilController::class, 'eliminarImagen'])
    ->name('eliminar-imagen')->middleware('auth');

Route::delete('/perfil/eliminar-cuenta', [perfilController::class, 'eliminarCuenta'])
    ->name('eliminar-cuenta')->middleware('auth');

// ---------------------- MODIFICAR REDES SOCIALES----------------------
Route::post('/perfil/guardar-redes', [redessocialesController::class, 'guardarRedes'])
    ->name('guardar-redes')->middleware('auth');

Route::post('/perfil/agregar-red', [redessocialesController::class, 'agregarRed'])
    ->name('agregar-red')->middleware('auth');

Route::post('/perfil/procesar-redes', [redessocialesController::class, 'procesarRedes'])
    ->name('procesar-redes')->middleware('auth');

Route::post('/perfil/eliminar-red-social-banda', [redessocialesController::class, 'eliminarRedesBanda'])
    ->name('eliminar-red-social-banda')->middleware('auth');

Route::post('/perfil/guardar-redes-staff', [redessocialesController::class, 'guardarRedesStaff'])
    ->name('guardar-redes-staff')->middleware('auth');

Route::post('/perfil/eliminar-red-social-staff', [redessocialesController::class, 'eliminarRedesStaff'])
    ->name('eliminar-red-social-staff')->middleware('auth');

// ----------------------- Panel de Usuarios -----------------------
Route::get('/panel-de-usuarios', [panelUsuariosController::class, 'panel'])
    ->name('panel-de-usuarios')->middleware('auth');

Route::post('/panel-de-usuarios/modificar-rol/{id}', [panelUsuariosController::class, 'modificarRol'])
    ->name('modificar-rol')->middleware('auth');

Route::post('/panel-de-usuarios/borrar-imagen/{id}', [panelUsuariosController::class, 'borrarImagen'])
    ->name('borrar-imagen')->middleware('auth');

Route::post('/panel-de-usuarios/eliminar-usuario/{id}', [panelUsuariosController::class, 'eliminarUsuario'])
    ->name('eliminar-usuario')->middleware('auth');

// ----------------------- Panel de Staff -----------------------
Route::get('/panel-de-staff', [panelStaffController::class, 'panel'])
    ->name('panel-de-staff')->middleware('auth');

Route::post('/panel-de-staff/modificar-rol/{id}', [panelStaffController::class, 'modificarRol'])
    ->name('modificar-rol-staff')->middleware('auth');

Route::post('/panel-de-staff/borrar-imagen/{id}', [panelStaffController::class, 'borrarImagenStaff'])
    ->name('borrar-imagen-staff')->middleware('auth');

Route::post('/panel-de-staff/eliminar-staff/{id}', [panelStaffController::class, 'eliminarStaff'])
    ->name('eliminar-staff')->middleware('auth');
//---------------------------------------------------------------

// EN CONSTRUCCION
Route::view('/underConstruction', "underConstruction")
    ->name('underConstruction');

//----------------------- CARPETA CONTENIDO -----------------------

//----------------------- CARPETA FORUM -----------------------
// VER PUBLICACIONES
Route::get('/foro', [ContenidoController::class, 'indexForo'])->name('foro');

// VER PUBLICACION DE FORO POR UNIDAD
Route::get('/foro/foroVer', [ContenidoController::class, 'publicacionForoUnica'])->name('foroVer');

//-----------------------------------------------------------------

//----------------------- CARPETA NEWS -----------------------
Route::get('/noticias', [ContenidoController::class, 'indexNoticias'])->name('noticias');

//-----------------------------------------------------------------

//----------------------- CARPETA HISTORY -----------------------
// VER PUBLICACIONES
Route::get('/biografia', [ContenidoController::class, 'indexBiografia'])->name('biografia');
//-----------------------------------------------------------------

// // Subir tipo de imagen
// Route::get('/imagenes', [subirImagenController::class, 'subirImagen'])
//     ->name('subirImagen')->middleware('auth');

// Route::post('/imagenes', [subirImagenController::class, 'subirImagenPost'])
//     ->name('subir-imagen')->middleware('auth');

// // REDES SOCIALES
// Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name("auth.redirect");
// Route::get('/auth/callback', [AuthController::class, 'callback'])->name("auth.callback");

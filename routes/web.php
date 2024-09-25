<?php
#Controllers
use App\Http\Controllers\AlbumGaleriaController;
use App\Http\Controllers\AlbumMusicaController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelStaffController;
use App\Http\Controllers\PanelUsuariosController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RedesSocialesController;
use App\Http\Controllers\SuperFanController;


#Modelo
use App\Models\Paisnacimiento;
use Illuminate\Support\Facades\Route;

//----------------------- SUELTOS ---------------------------------------------------
#
// INICIO
Route::get('/', [InicioController::class, 'index'])
    ->name('inicio');
// EN CONSTRUCCION
Route::view('/underConstruction', "underConstruction")
    ->name('underConstruction');
// TERMINOS Y CONDICIONES
Route::view('/terminos-de-servicio', 'termsService')->name('terminos-de-servicio');
####################################################################################
//----------------------- CARPETA AUTH -----------------------------------------------
#
// ----------------------------- Reestablecer ----------------------------------------
Route::view('/solicitarPin', 'auth.SolicitarPin')
    ->name('solicitarPin')->middleware('guest');

Route::view('/comprobarPin', 'auth.comprobarPin')
    ->name('comprobarPin')->middleware('guest');

Route::view('/restablecer', 'auth.restablecer')
    ->name('restablecer')->middleware('guest');
// ----------------------------- LOGIN -----------------------------------------------
Route::post('/inicia-sesion', [loginController::class, 'login'])
    ->name('inicia-sesion')->middleware('guest');

Route::post('/validar-registro', [loginController::class, 'register'])
    ->name('validar-registro')->middleware('guest');

Route::post('/solicitar-pin', [loginController::class, 'solicitarPin'])
    ->name('solicitar-pin')->middleware('guest');

Route::post('/comprobar-pin', [loginController::class, 'comprobarPin'])
    ->name('comprobar-pin')->middleware('guest');

Route::post('/restablecer-contrasenia', [loginController::class, 'restablecer'])
    ->name('restablecer-contrasenia')->middleware('guest');

Route::get('/logout', [loginController::class, 'logout'])
    ->name('logout');
// -------------------------------- Vistas inicio de sesion --------------------------
Route::view('/login', "auth.login")
    ->name('login')->middleware('guest');

Route::get('/registro', function () {
    $paises = new Paisnacimiento();
    $paises = Paisnacimiento::get();

    return view('auth.registro', compact('paises'));
})->name('registro')->middleware('guest');
#######################################################################################
//---------------------------------- CARPETA PROFILE ----------------------------------
#
// ---------------------------------- Perfil ------------------------------------------
Route::get('/perfil', [perfilController::class, 'perfil'])
    ->name('perfil')->middleware('auth');

Route::get('/modificar-perfil', [perfilController::class, 'modificarPerfil'])
    ->name('modificar-perfil')->middleware('auth');
// -------------------------------------------- Redes ---------------------------------
Route::get('/modificar-redes', [redessocialesController::class, 'modificarRedes'])
    ->name('modificar-redes')->middleware('auth');
// ---------------------------------- Perfil POST -------------------------------------
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
// --------------------------------- MODIFICAR REDES SOCIALES-------------------------
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
// ---------------------------------- Panel de Usuarios ------------------------------------------
Route::get('/panel-de-usuarios', [panelUsuariosController::class, 'panel'])
    ->name('panel-de-usuarios')->middleware('auth');

Route::post('/panel-de-usuarios/modificar-rol/{id}', [panelUsuariosController::class, 'modificarRol'])
    ->name('modificar-rol')->middleware('auth');

Route::post('/panel-de-usuarios/borrar-imagen/{id}', [panelUsuariosController::class, 'borrarImagen'])
    ->name('borrar-imagen')->middleware('auth');

Route::post('/panel-de-usuarios/eliminar-usuario/{id}', [panelUsuariosController::class, 'eliminarUsuario'])
    ->name('eliminar-usuario')->middleware('auth');
// ---------------------------------- Panel de Staff --------------------------------------------
Route::get('/panel-de-staff', [panelStaffController::class, 'panel'])
    ->name('panel-de-staff')->middleware('auth');

Route::post('/panel-de-staff/modificar-rol/{id}', [panelStaffController::class, 'modificarRol'])
    ->name('modificar-rol-staff')->middleware('auth');

Route::post('/panel-de-staff/borrar-imagen/{id}', [panelStaffController::class, 'borrarImagenStaff'])
    ->name('borrar-imagen-staff')->middleware('auth');

Route::post('/panel-de-staff/eliminar-staff/{id}', [panelStaffController::class, 'eliminarStaff'])
    ->name('eliminar-staff')->middleware('auth');
##################################################################################################
//--------------------------------------------- CARPETA EVENTOS ----------------------------------
// ------------------------------------------------- Eventos -------------------------------------
Route::get('/eventos', [eventosController::class, 'eventos'])
    ->name('eventos');
##################################################################################################
//----------------------- CARPETA CONTENIDO -----------------------
#
// SUPERFAN (Descargas)
Route::get('/superFan', [SuperFanController::class, 'indexSuperFan'])->name('superFan');
//----------------------- CARPETA HISTORY -----------------------
// VER BIOGRAFIA
Route::get('/biografia', [ContenidoController::class, 'indexBiografia'])->name('biografia');
#
//----------------------- CARPETA NEWS -----------------------
// VER NOTICIAS
Route::get('/noticias', [ContenidoController::class, 'indexNoticias'])->name('noticias');

// VER NOTICIAS POR UNIDAD
Route::get('/noticias/noticiaUnica/{data}', [ContenidoController::class, 'publicacionUnicaNoticias'])->name('noticiaUnica');
#
//----------------------- CARPETA FORUM -----------------------
// VER FORO
Route::get('/foro', [ContenidoController::class, 'indexForo'])->name('foro');

// VER PUBLICACION DE FORO POR UNIDAD
Route::get('/foro/foroUnico/{data}', [ContenidoController::class, 'publicacionUnicaForo'])->name('foroUnico');
##################################################################################################
//------------------------ CARPETA JOB --------------------------
// VER ARTISTAS
Route::get('/job/artistas', [JobsController::class, 'indexArtistas'])->name('artistas');

// VER STAFF
Route::get('/job/staff', [JobsController::class, 'indexStaff'])->name('staff');
##################################################################################################
//------------------------ CARPETA UTILS (ALBUMS) ------------------------
// VER ALBUM Musica
Route::get('/albumMusica/discografia', [AlbumMusicaController::class, 'indexAlbumMusica'])->name('discografia');
// VER ALBUM Galera
Route::get('/albumGaleria/albumGaleria', [AlbumGaleriaController::class, 'indexAlbumGaleria'])->name('albumGaleria');
// Traer API YT
Route::post('/albumGaleria/actualizarYt', [AlbumGaleriaController::class, 'botonObtenerVideoYt'])->name('actualizarYt');
##################################################################################################

// // Subir tipo de imagen
// Route::get('/imagenes', [subirImagenController::class, 'subirImagen'])
//     ->name('subirImagen')->middleware('auth');

// Route::post('/imagenes', [subirImagenController::class, 'subirImagenPost'])
//     ->name('subir-imagen')->middleware('auth');

// // REDES SOCIALES
// Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name("auth.redirect");
// Route::get('/auth/callback', [AuthController::class, 'callback'])->name("auth.callback");

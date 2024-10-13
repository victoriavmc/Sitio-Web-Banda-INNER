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
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SuperFanController;
#Modelo
use App\Models\Paisnacimiento;
use App\Models\Reportes;
use Illuminate\Support\Facades\Route;

//----------------------- SUELTOS 
// INICIO
Route::get('/', [InicioController::class, 'index'])
    ->name('inicio');
// EN CONSTRUCCION
Route::view('/underConstruction', "underConstruction")
    ->name('underConstruction');
// TERMINOS Y CONDICIONES
Route::view('/terminos-de-servicio', 'termsService')
    ->name('terminos-de-servicio');
######################################
//----------------------- CARPETA AUTH 
#
//----------------------- Reestablecer 
Route::view('/solicitarPin', 'auth.SolicitarPin')
    ->name('solicitarPin')->middleware('guest');

Route::view('/comprobarPin', 'auth.comprobarPin')
    ->name('comprobarPin')->middleware('guest');

Route::view('/restablecer', 'auth.restablecer')
    ->name('restablecer')->middleware('guest');

//----------------------- LOGIN 
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
//----------------------- Vistas inicio de sesion 
Route::view('/login', "auth.login")
    ->name('login')->middleware('guest');

Route::get('/registro', function () {
    $paises = new Paisnacimiento();
    $paises = Paisnacimiento::get();

    return view('auth.registro', compact('paises'));
})->name('registro')->middleware('guest');
###################################################
//----------------------- CARPETA PROFILE
#
//----------------------- Perfil 
Route::get('/perfil', [perfilController::class, 'perfil'])
    ->name('perfil')->middleware('auth');

Route::get('/modificar-perfil', [perfilController::class, 'modificarPerfil'])
    ->name('modificar-perfil')->middleware('auth');

// PERFIL AJENO
Route::get('/perfil-ajeno/{id}', [perfilController::class, 'verPerfilAjeno'])
    ->name('perfil-ajeno');

//----------------------- Redes
Route::get('/modificar-redes', [redessocialesController::class, 'modificarRedes'])
    ->name('modificar-redes')->middleware('auth');
//----------------------- Perfil POST
Route::post('/perfil/editar-datos', [perfilController::class, 'editarInfoCuenta'])
    ->name('editar-datos')->middleware('auth');

Route::post('/perfil/editar-contrasenia', [perfilController::class, 'editarContrasenia'])
    ->name('editar-contrasenia')->middleware('auth');

Route::post('/perfil/editar-correo', [perfilController::class, 'editarCorreo'])
    ->name('editar-correo')->middleware('auth');

Route::post('/perfil/cambiar-imagen', [perfilController::class, 'cambiarImagen'])
    ->name('cambiar-imagen')->middleware('auth');

Route::post('/perfil/eliminar-imagen', [perfilController::class, 'eliminarImagen'])
    ->name('eliminar-imagen')->middleware('auth');

#### VER... 
Route::delete('/perfil/eliminar-cuenta', [perfilController::class, 'eliminarCuenta'])
    ->name('eliminar-cuenta')->middleware('auth');
//----------------------- MODIFICAR REDES SOCIALES
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

Route::post('/perfil/eliminar-red-social-staff', [redessocialesController::class, 'eliminarRedSocialStaff'])
    ->name('eliminar-red-social-staff')->middleware('auth');
//----------------------- Panel de Usuarios
Route::get('/panel-de-usuarios', [panelUsuariosController::class, 'panel'])
    ->name('panel-de-usuarios')->middleware('auth');

Route::post('/panel-de-usuarios/modificar-rol/{id}', [panelUsuariosController::class, 'modificarRol'])
    ->name('modificar-rol')->middleware('auth');

Route::post('/panel-de-usuarios/borrar-imagen/{id}', [panelUsuariosController::class, 'borrarImagen'])
    ->name('borrar-imagen')->middleware('auth');

Route::post('/panel-de-usuarios/eliminar-usuario/{id}', [panelUsuariosController::class, 'eliminarUsuario'])
    ->name('eliminar-usuario')->middleware('auth');
//----------------------- Panel de Staff
Route::get('/panel-de-staff', [panelStaffController::class, 'panel'])
    ->name('panel-de-staff')->middleware('auth');

Route::post('/panel-de-staff/modificar-rol/{id}', [panelStaffController::class, 'modificarRol'])
    ->name('modificar-rol-staff')->middleware('auth');

Route::post('/panel-de-staff/borrar-imagen/{id}', [panelStaffController::class, 'borrarImagenStaff'])
    ->name('borrar-imagen-staff')->middleware('auth');

Route::post('/panel-de-staff/eliminar-staff/{id}', [panelStaffController::class, 'eliminarStaff'])
    ->name('eliminar-staff')->middleware('auth');
##############################################
//----------------------- Eventos 
Route::get('/eventos', [eventosController::class, 'eventos'])
    ->name('eventos');

Route::get('/eventos/lugares-cargados', [eventosController::class, 'lugaresCargados'])
    ->name('lugares-cargados')->middleware('auth');

Route::delete('/eventos/lugares-cargados/eliminar-lugar/{id}', [eventosController::class, 'eliminarLugar'])
    ->name('eliminar-lugar')->middleware('auth');

Route::put('/eventos/lugares-cargados/modificar-lugar/{id}', [eventosController::class, 'modificarLugar'])
    ->name('modificar-lugar')->middleware('auth');

Route::put('/eventos/lugares-cargados/modificar-ubicacion/{id}', [eventosController::class, 'modificarUbicacion'])
    ->name('modificar-ubicacion')->middleware('auth');

Route::delete('/eventos/lugares-cargados/eliminar-ubicacion/{id}', [eventosController::class, 'eliminarUbicacion'])
    ->name('eliminar-ubicacion')->middleware('auth');

Route::get('/eventos/crear', [eventosController::class, 'formularioCrear'])
    ->name('crear-formulario')->middleware('auth');

Route::post('/eventos/crear', [eventosController::class, 'crearEvento'])
    ->name('crear-evento')->middleware('auth');

Route::get('/eventos/modificar/{id}', [eventosController::class, 'formularioModificar'])
    ->name('modificar-formulario')->middleware('auth');

Route::put('/eventos/modificar/{id}', [eventosController::class, 'modificarEvento'])
    ->name('modificar-evento')->middleware('auth');

Route::delete('/eventos/eliminar/{id}', [eventosController::class, 'eliminarEvento'])
    ->name('eliminar-evento')->middleware('auth');
##################################################################################################
//----------------------- CARPETA CONTENIDO -----------------------
#
// SUPERFAN (Descargas)
Route::get('/superFan', [SuperFanController::class, 'indexSuperFan'])
    ->name('superFan');
//----------------------- CARPETA HISTORY 
//----------------------- VER BIOGRAFIA
Route::get('/biografia', [ContenidoController::class, 'indexBiografia'])
    ->name('biografia');
#
//----------------------- CARPETA NEWS 
//----------------------- VER NOTICIAS
Route::get('/noticias', [ContenidoController::class, 'indexNoticias'])
    ->name('noticias');

//----------------------- VER NOTICIAS POR UNIDAD
Route::get('/noticias/noticiaUnica/{data}', [ContenidoController::class, 'publicacionUnicaNoticias'])
    ->name('noticiaUnica');

//----------------------- Ruta para ver el formulario de crear noticias
Route::get('/noticias/crearnoticias', [ContenidoController::class, 'verFormularioNoticia'])
    ->name('verFormularioNoticia');

//----------------------- Ruta para crear una nueva publicación
Route::post('/news/crearnoticias/{type}', [ContenidoController::class, 'crearP'])
    ->name('crearP')->middleware('auth');

//----------------------- Ruta para mostrar el formulario de modificación
Route::get('/news/noticiaUnica/modificar/{id}', [ContenidoController::class, 'editarP'])
    ->name('editarP')->middleware('auth');

//----------------------- Ruta para actualizar la publicación (este es el método POST)
Route::post('/foro/noticiasmodificar/modificar/{id}', [ContenidoController::class, 'modificarP'])
    ->name('modificarP')->middleware('auth');

//----------------------- REPORTAR FORO PUBLICACION
Route::post('/actividad/{id}/reportar', [ContenidoController::class, 'reportarActividad'])
    ->name('reportarActividad')->middleware('auth');

//----------------------- CARPETA FORUM
//----------------------- VER FORO
Route::get('/foro', [ContenidoController::class, 'indexForo'])
    ->name('foro');

//----------------------- VER PUBLICACION DE FORO POR UNIDAD
Route::get('/foro/foroUnico/{data}', [ContenidoController::class, 'publicacionUnicaForo'])
    ->name('foroUnico')->middleware('auth');

//----------------------- Ruta para ver el formulario
Route::get('/foro/foropublicaciones', [ContenidoController::class, 'verFormularioForo'])
    ->name('verFormularioForo')->middleware('auth');

//----------------------- Ruta para crear la publicación
Route::post('/foro/foropublicaciones/{type}', [ContenidoController::class, 'crearP'])
    ->name('crearP')->middleware('auth');

//----------------------- Ruta para mostrar el formulario de modificación
Route::get('/foro/foropublicaciones/modificar/{id}', [ContenidoController::class, 'editarP'])
    ->name('editarP')->middleware('auth');

//----------------------- Ruta para actualizar la publicación (este es el método POST)
Route::post('/foro/foropublicaciones/modificar/{id}', [ContenidoController::class, 'modificarP'])
    ->name('modificarP')->middleware('auth');

//----------------------- Ruta para eliminar la publicacion especifica
Route::delete('/foro/foropublicaciones/eliminar/{id}', [ContenidoController::class, 'eliminarContenido'])
    ->name('eliminarContenido')->middleware('auth');

//----------------------- CREAR Comentario
Route::post('/comentarios/{idContent}', [ContenidoController::class, 'crearComentario'])
    ->name('crearComentario')->middleware('auth');

//----------------------- MODIFICAR COMENTARIO
Route::put('/comentarios/{idComentario}', [ContenidoController::class, 'modificarComentario'])
    ->name('modificarComentario')->middleware('auth');

//----------------------- ELIMINAR COMENTARIO
Route::delete('/comentario/{id}', [ContenidoController::class, 'eliminarComentario'])
    ->name('eliminarComentario')->middleware('auth');

###############################################
//----------------------- CARPETA JOB 
//----------------------- VER ARTISTAS
Route::get('/job/artistas', [JobsController::class, 'indexArtistas'])
    ->name('artistas');

Route::put('/artistas/{id}/modificar-imagen', [JobsController::class, 'modificarImagenArtista'])
    ->name('artistas.modificarImagen');

// VER STAFF
Route::get('/job/staff', [JobsController::class, 'indexStaff'])
    ->name('staff');
##################################################################################################
//------------------------ CARPETA UTILS (ALBUMS) ------------------------
// VER ALBUM Musica
Route::get('/albumMusica/discografia', [AlbumMusicaController::class, 'indexAlbumMusica'])
    ->name('discografia');
// VER ALBUM Galera
Route::get('/albumGaleria/albumGaleria', [AlbumGaleriaController::class, 'indexAlbumGaleria'])
    ->name('albumGaleria');
// Traer API YT
Route::post('/albumGaleria/actualizarYt', [AlbumGaleriaController::class, 'botonObtenerVideoYt'])
    ->name('actualizarYt')->middleware('auth');
##################################################################################################
//------------------------ REPORTES ------------------------
// VER REPORTES
Route::get('/reportes/{id}', [ReportesController::class, 'manejoreporte'])
    ->name('reportarStaff');

Route::get('/reportes/{id}', [ReportesController::class, 'manejoreporte'])
    ->name('reportarUsuario');
##################################################################################################

// Subir tipo de imagen
// Route::get('/imagenes', [subirImagenController::class, 'subirImagen'])
//     ->name('subirImagen')->middleware('auth');

// Route::post('/imagenes', [subirImagenController::class, 'subirImagenPost'])
//     ->name('subir-imagen')->middleware('auth');

// // REDES SOCIALES
// Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name("auth.redirect");
// Route::get('/auth/callback', [AuthController::class, 'callback'])->name("auth.callback");

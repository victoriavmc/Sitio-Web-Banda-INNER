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
use App\Http\Controllers\cancionController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\MercadoPagoWebhookController;

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

Route::get('/reactivar-cuenta/{id}', [loginController::class, 'vistaReactivarCuenta'])
    ->name('reactivar-cuenta')->middleware('guest');

// Ruta hacia contacto
Route::get('/contacto/{id}', [loginController::class, 'contacto'])
    ->name('contacto')->middleware('guest');
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

// Reportar perfil ajeno
Route::post('/perfil-ajeno/reportar/{id}', [perfilController::class, 'reportarCuenta'])
    ->name('reportarPerfilAjeno');
// ->middleware('auth');


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

Route::get('/biografia/modificar/{id}/{tipo}', [ContenidoController::class, 'editarP'])
    ->name('editarP')->middleware('auth');

Route::post('/biografia/modificarP/{id}', [ContenidoController::class, 'modificarP'])
    ->name('modificarP')->middleware('auth');
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
Route::get('/news/noticiaUnica/modificar/{id}/{tipo}', [ContenidoController::class, 'editarP'])
    ->name('editarP')->middleware('auth');

//----------------------- Ruta para actualizar la publicación (este es el método POST)
Route::post('/foro/noticiasmodificar/modificarP/{id}', [ContenidoController::class, 'modificarP'])
    ->name('modificarP')->middleware('auth');

//----------------------- REPORTAR FORO PUBLICACION
Route::post('/actividad/{id}/reportar', [ContenidoController::class, 'reportarActividadEspecifica'])
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
Route::get('/foro/foropublicaciones/modificar/{id}/{tipo}', [ContenidoController::class, 'editarP'])
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

//----------------------- LIKE O DISLIKE PUBLICACION
Route::post('/puntuacion/{tipo}/{id}', [ContenidoController::class, 'likeDislikeActividad'])
    ->name('puntuacion')
    ->middleware('auth');

###############################################
//----------------------- CARPETA JOB 
//----------------------- VER ARTISTAS
Route::get('/job/artistas', [JobsController::class, 'indexArtistas'])
    ->name('artistas');

Route::put('/artistas/{id}/modificar-imagen', [JobsController::class, 'modificarImagenArtista'])
    ->name('artistas.modificarImagen')->middleware('auth');

// VER STAFF
Route::get('/job/staff', [JobsController::class, 'indexStaff'])
    ->name('staff');

Route::get('/descargas', [SuperFanController::class, 'descargas'])->name('descargas');
##################################################################################################
//------------------------ CARPETA UTILS (ALBUMS) ------------------------
// VER ALBUM Musica
Route::get('/albumMusica/discografia', [AlbumMusicaController::class, 'indexAlbumMusica'])
    ->name('discografia');

// ALBUMS
// Ruta formulario crear un álbum
Route::get('/crear-album', [AlbumController::class, 'manejarAlbum'])
    ->name('crear-album')->middleware('auth');

// Ruta para manejar álbum (crear)
Route::post('/manejo-album/{accion}/{tipoAlbum}', [AlbumController::class, 'manejoAlbum'])
    ->name('manejo-album')->middleware('auth');

// Ruta para manejar álbum (modificar)
Route::post('/modificar-album/', [AlbumController::class, 'manejoAlbumEliminarModificar'])
    ->name('modificarAlbumEspecifico')->middleware('auth');

// Ruta para manejar álbum (eliminar)
Route::post('/manejo-album/', [AlbumController::class, 'manejoAlbumEliminarModificar'])
    ->name('eliminarAlbumEspecifico')->middleware('auth');

// CRUD CANCIONES

//Ver cancion
Route::get('/albumMusica/discografia/ver-cancion/{id}', [AlbumMusicaController::class, 'verCancion'])
    ->name('ver-cancion');

Route::get('/albumMusica/discografia/crear-cancion/{id}', [CancionController::class, 'formularioCrearCancion'])
    ->name('formulario-crear-cancion')->middleware('auth');

Route::post('/albumMusica/discografia/crear-cancion/{id}', [CancionController::class, 'guardarCancion'])->name('guardar-cancion');

Route::get('/albumMusica/discografia/modificar-cancion/{id}', [CancionController::class, 'formularioModificarCancion'])
    ->name('formulario-modificar-cancion')->middleware('auth');

Route::put('/albumMusica/discografia/modificar-cancion/{id}', [CancionController::class, 'actualizarCancion'])
    ->name('modificar-cancion')->middleware('auth');

Route::delete('/albumMusica/discografia/eliminar-cancion/{id}', [CancionController::class, 'eliminarCancion'])
    ->name('eliminar-cancion')->middleware('auth');

// VER ALBUM Galera
Route::get('/albumGaleria/albumGaleria', [AlbumGaleriaController::class, 'indexAlbumGaleria'])
    ->name('albumGaleria');

// Ruta para mostrar un álbum específico
Route::get('/album/{idAlbumEspecifico}/{tipo}', [AlbumController::class, 'mostrarDeUno'])->name('mostrar.de.uno');

// Ruta para agregar un video o imagen a un álbum
Route::post('/album/', [AlbumController::class, 'agregarVideoAlbum'])->name('agregarVideoAlbum');

// Ruta para mostrar la galería interna
Route::get('/galeria-interna', [AlbumController::class, 'metodoGaleriaInterna'])->name('components.galeria-interna');
// Ruta para eliminar objeto especifico de la galería interna
Route::post('/eliminar-objeto', [AlbumController::class, 'eliminarObjeto'])->name('eliminar.objeto');


// Traer API YT
Route::post('/albumGaleria/actualizarYt', [AlbumGaleriaController::class, 'botonObtenerVideoYt'])
    ->name('actualizarYt')->middleware('auth');
##################################################################################################
//------------------------ REPORTES ------------------------
// VER REPORTES
Route::get('/reportes/{id}', [ReportesController::class, 'manejoreporte'])
    ->name('reportarStaff')->middleware('auth');

Route::get('/reportes/{id}', [ReportesController::class, 'manejoreporte'])
    ->name('reportarUsuario')->middleware('auth');

Route::get('reportes/decidir-reporte/{id}', [ReportesController::class, 'vistaDecideReporte'])
    ->name('vistaDecideReporte')->middleware('auth');

Route::post('reportes/decidir-reporte/{id}', [ReportesController::class, 'decideReportes'])
    ->name('decideReporte')->middleware('auth');

Route::delete('repotes/eliminar-motivo/{id}', [ReportesController::class, 'eliminarMotivo'])
    ->name('eliminarMotivo')->middleware('auth');

Route::post('reportes/crear-motivo', [ReportesController::class, 'crearMotivo'])
    ->name('crearMotivo')->middleware('auth');

Route::put('reportes/modificar-motivo/{id}', [ReportesController::class, 'modificarMotivo'])
    ->name('modificarMotivo')->middleware('auth');

Route::delete('reportes/eliminar-motivo-admin/{id}', [ReportesController::class, 'eliminarMotivoAdmin'])
    ->name('eliminarMotivoAdmin')->middleware('auth');
##################################################################################################
// Rutas para Mercado Pago
Route::view('/mercadopago', 'mptest')
    ->name('mercadopago');

Route::post('/create-preference', [MercadoPagoController::class, 'createPaymentPreference'])
    ->name('mercadopago.create_preference');

Route::get('/mercadopago/failed', [MercadoPagoController::class, 'failed'])
    ->name('mercadopago.failed');

Route::get('/mercadopago/success', [MercadoPagoController::class, 'paymentSuccess'])
    ->name('mercadopago.success');

Route::get('/mercadopago/comprobante', [MercadoPagoController::class, 'comprobantePdf'])
    ->name('mercadopago.comprobante');

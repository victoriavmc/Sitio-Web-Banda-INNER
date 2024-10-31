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
use App\Http\Controllers\CancionController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ComprobantesController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\MercadoPagoWebhookController;
use App\Http\Controllers\PrecioController;
#Modelo
use App\Models\Paisnacimiento;
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
Route::post('/inicia-sesion', [LoginController::class, 'login'])
    ->name('inicia-sesion')->middleware('guest');

Route::post('/validar-registro', [LoginController::class, 'register'])
    ->name('validar-registro')->middleware('guest');

Route::post('/solicitar-pin', [LoginController::class, 'solicitarPin'])
    ->name('solicitar-pin')->middleware('guest');

Route::post('/comprobar-pin', [LoginController::class, 'comprobarPin'])
    ->name('comprobar-pin')->middleware('guest');

Route::post('/restablecer-contrasenia', [LoginController::class, 'restablecer'])
    ->name('restablecer-contrasenia')->middleware('guest');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/reactivar-cuenta/{id}', [LoginController::class, 'vistaReactivarCuenta'])
    ->name('reactivar-cuenta')->middleware('guest');

// Ruta hacia contacto
Route::get('/contacto/{id}', [LoginController::class, 'contacto'])
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
Route::get('/perfil', [PerfilController::class, 'perfil'])
    ->name('perfil')->middleware('auth');

Route::get('/modificar-perfil', [PerfilController::class, 'modificarPerfil'])
    ->name('modificar-perfil')->middleware('auth');

// PERFIL AJENO
Route::get('/perfil-ajeno/{id}', [PerfilController::class, 'verPerfilAjeno'])
    ->name('perfil-ajeno')->middleware('auth');

// Reportar perfil ajeno
Route::post('/perfil-ajeno/reportar/{id}', [PerfilController::class, 'reportarCuenta'])
    ->name('reportarPerfilAjeno')->middleware('auth');

//----------------------- Notificaciones
Route::get('/perfil/notificaciones', [NotificacionesController::class, 'notificaciones'])
    ->name('notificaciones')->middleware('auth');

//----------------------- Redes
Route::get('/modificar-redes', [RedessocialesController::class, 'modificarRedes'])
    ->name('modificar-redes')->middleware('auth');
//----------------------- Perfil POST
Route::post('/perfil/editar-datos', [PerfilController::class, 'editarInfoCuenta'])
    ->name('editar-datos')->middleware('auth');

Route::post('/perfil/editar-contrasenia', [PerfilController::class, 'editarContrasenia'])
    ->name('editar-contrasenia')->middleware('auth');

Route::post('/perfil/editar-correo', [PerfilController::class, 'editarCorreo'])
    ->name('editar-correo')->middleware('auth');

Route::post('/perfil/cambiar-imagen', [PerfilController::class, 'cambiarImagen'])
    ->name('cambiar-imagen')->middleware('auth');

Route::post('/perfil/eliminar-imagen', [PerfilController::class, 'eliminarImagen'])
    ->name('eliminar-imagen')->middleware('auth');

#### VER... 
Route::delete('/perfil/eliminar-cuenta', [PerfilController::class, 'eliminarCuenta'])
    ->name('eliminar-cuenta')->middleware('auth');
//----------------------- MODIFICAR REDES SOCIALES
Route::post('/perfil/guardar-redes', [RedessocialesController::class, 'guardarRedes'])
    ->name('guardar-redes')->middleware('auth');

Route::post('/perfil/agregar-red', [RedessocialesController::class, 'agregarRed'])
    ->name('agregar-red')->middleware('auth');

Route::post('/perfil/procesar-redes', [RedessocialesController::class, 'procesarRedes'])
    ->name('procesar-redes')->middleware('auth');

Route::post('/perfil/eliminar-red-social-banda', [RedessocialesController::class, 'eliminarRedesBanda'])
    ->name('eliminar-red-social-banda')->middleware('auth');

Route::post('/perfil/guardar-redes-staff', [RedessocialesController::class, 'guardarRedesStaff'])
    ->name('guardar-redes-staff')->middleware('auth');

Route::post('/perfil/eliminar-red-social-staff', [RedessocialesController::class, 'eliminarRedSocialStaff'])
    ->name('eliminar-red-social-staff')->middleware('auth');
//----------------------- Panel de Usuarios
Route::get('/panel-de-usuarios', [PanelUsuariosController::class, 'panel'])
    ->name('panel-de-usuarios')->middleware('auth');

Route::post('/panel-de-usuarios/modificar-rol/{id}', [PanelUsuariosController::class, 'modificarRol'])
    ->name('modificar-rol')->middleware('auth');

Route::post('/panel-de-usuarios/borrar-imagen/{id}', [PanelUsuariosController::class, 'borrarImagen'])
    ->name('borrar-imagen')->middleware('auth');

Route::post('/panel-de-usuarios/eliminar-usuario/{id}', [PanelUsuariosController::class, 'eliminarUsuario'])
    ->name('eliminar-usuario')->middleware('auth');
//----------------------- Panel de Staff
Route::get('/panel-de-staff', [PanelStaffController::class, 'panel'])
    ->name('panel-de-staff')->middleware('auth');

Route::post('/panel-de-staff/modificar-rol/{id}', [PanelStaffController::class, 'modificarRol'])
    ->name('modificar-rol-staff')->middleware('auth');

Route::post('/panel-de-staff/borrar-imagen/{id}', [PanelStaffController::class, 'borrarImagenStaff'])
    ->name('borrar-imagen-staff')->middleware('auth');

Route::post('/panel-de-staff/eliminar-staff/{id}', [PanelStaffController::class, 'eliminarStaff'])
    ->name('eliminar-staff')->middleware('auth');
##############################################
//----------------------- Eventos 
Route::get('/eventos', [EventosController::class, 'eventos'])
    ->name('eventos');

Route::get('/eventos/lugares-cargados', [EventosController::class, 'lugaresCargados'])
    ->name('lugares-cargados')->middleware('auth');

Route::delete('/eventos/lugares-cargados/eliminar-lugar/{id}', [EventosController::class, 'eliminarLugar'])
    ->name('eliminar-lugar')->middleware('auth');

Route::put('/eventos/lugares-cargados/modificar-lugar/{id}', [EventosController::class, 'modificarLugar'])
    ->name('modificar-lugar')->middleware('auth');

Route::put('/eventos/lugares-cargados/modificar-ubicacion/{id}', [EventosController::class, 'modificarUbicacion'])
    ->name('modificar-ubicacion')->middleware('auth');

Route::delete('/eventos/lugares-cargados/eliminar-ubicacion/{id}', [EventosController::class, 'eliminarUbicacion'])
    ->name('eliminar-ubicacion')->middleware('auth');

Route::get('/eventos/crear', [EventosController::class, 'formularioCrear'])
    ->name('crear-formulario')->middleware('auth');

Route::post('/eventos/crear', [EventosController::class, 'crearEvento'])
    ->name('crear-evento')->middleware('auth');

Route::get('/eventos/modificar/{id}', [EventosController::class, 'formularioModificar'])
    ->name('modificar-formulario')->middleware('auth');

Route::put('/eventos/modificar/{id}', [EventosController::class, 'modificarEvento'])
    ->name('modificar-evento')->middleware('auth');

Route::delete('/eventos/eliminar/{id}', [EventosController::class, 'eliminarEvento'])
    ->name('eliminar-evento')->middleware('auth');

Route::post('/eventos/actualizar-precio/{id}', [EventosController::class, 'actualizarPrecio'])
    ->name('actualizar-precio')->middleware('auth');
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

Route::post('/descargas', [SuperFanController::class, 'descargarAlbumMusical'])->name('descargarAlbumMusical');
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

Route::get('/reportes/decidir-reporte/{id}', [ReportesController::class, 'vistaDecideReporte'])
    ->name('vistaDecideReporte')->middleware('auth');

Route::post('/reportes/decidir-reporte/{id}', [ReportesController::class, 'decideReportes'])
    ->name('decideReporte')->middleware('auth');

Route::delete('/repotes/eliminar-motivo/{id}', [ReportesController::class, 'eliminarMotivo'])
    ->name('eliminarMotivo')->middleware('auth');

Route::post('/reportes/crear-motivo', [ReportesController::class, 'crearMotivo'])
    ->name('crearMotivo')->middleware('auth');

Route::put('/reportes/modificar-motivo/{id}', [ReportesController::class, 'modificarMotivo'])
    ->name('modificarMotivo')->middleware('auth');

Route::delete('/reportes/eliminar-motivo-admin/{id}', [ReportesController::class, 'eliminarMotivoAdmin'])
    ->name('eliminarMotivoAdmin')->middleware('auth');
##################################################################################################
// Rutas para Mercado Pago
Route::view('/mercadopago', 'api.mptest')
    ->name('mercadopago')->middleware('auth');

// Crear preferencia de pago
Route::post('/create-preference', [MercadoPagoController::class, 'createPaymentPreference'])
    ->name('mercadopago.create_preference')->middleware('auth');

// Redirecciones de éxito y error
Route::get('/mercadopago/failed', [MercadoPagoController::class, 'failed'])
    ->name('mercadopago.failed')->middleware('auth');

Route::get('/mercadopago/success', [MercadoPagoController::class, 'paymentSuccess'])
    ->name('mercadopago.success')->middleware('auth');

// Vista y descarga del comprobante
Route::get('/mercadopago/comprobante/{id}', [MercadoPagoController::class, 'comprobantePdf'])
    ->name('mercadopago.comprobante')->middleware('auth');

// Lista de comprobantes
Route::get('/comprobantes', [ComprobantesController::class, 'listarComprobantes'])
    ->name('comprobantes.listar')->middleware('auth');

// Descargar comprobantes en Excel
Route::get('/comprobantes/excel', [ComprobantesController::class, 'descargarExcel'])
    ->name('descargar.excel')->middleware('auth');

// Orden de Pago del Usuario
Route::get('/ordenes-de-pago', [ComprobantesController::class, 'listarComprobantesUsuarioEspecifico'])
    ->name('orden-de-pago')->middleware('auth');

Route::post('/actualizar-precio', [PrecioController::class, 'cambiaPrecioSuscripcion'])->name('actualizar.precio');

Route::get('/notificaciones', [NotificacionesController::class, 'notificaciones'])
    ->name('notificaciones.index')->middleware('auth');

Route::post('/notificaciones/guardar', [NotificacionesController::class, 'guardarPreferencias'])
    ->name('notificaciones.guardar')->middleware('auth');

Route::post('/notificaciones/cancelar', [NotificacionesController::class, 'cancelarTodo'])
    ->name('notificaciones.cancelar')->middleware('auth');

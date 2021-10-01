<?php

use App\Events\Publicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('menu')->group(function(){
    Route::get('menuItems','ci2Asset\\menu@getMenuItems');
    Route::get('menu2Items','ci2Asset\\menu@getMenu2Items');
    Route::get('menu3Items','ci2Asset\\menu@getMenu3Items');
});
Route::prefix('DatosUsuario')->group(function(){
    Route::post('cumpleaneros','UsuariosDatosController@obtenerCumpleaneros');
    Route::post('contactos','UsuariosDatosController@obtenerContactos');
});


                     //prefix para acceder
/* por ejemplo para acceder a CiPublicaciones@getPublicaciones debo hacer esto
Publicaciones/getPublicaciones
*/
Route::prefix('Publicaciones')->group(function(){
    Route::post('getPublicaciones','Ci2Publicaciones@getPublicaciones');
    Route::post('getComentarios','Ci2Publicaciones@getComentarios');
    Route::post('postComentarios','Ci2Publicaciones@postComentarios');
    Route::post('getRecomendacion','Ci2Publicaciones@getRecomendacion');
    Route::post('postRecomendacion','Ci2Publicaciones@postRecomendacion');
    Route::post('getcomentariospublicacion','Ci2Publicaciones@getcomentariospublicacion');

    //aqui va organizado asi
    //como quiero acceder al controller      //donde se encuentra mi controller
    Route::post('postPublicaciones','Ci2Publicaciones@aggPublicaciones');

    Route::post('delPublicaciones','Ci2Publicaciones@delPublicaciones');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
Route::prefix('ejemplo')->group(function(){
    Route::post('ejemplopusher','Ci2Publicaciones@evento');
    Route::post('ejemploechopusher','prueba@send');
});

Route::prefix('Comunicados')->group(function(){
    Route::post('getcomunicados','ComunicadosController@obtenerComunicado');
    Route::post('postcomunicados','ComunicadosController@insertarComunicado');
    Route::post('elimarcomunicados','ComunicadosController@eliminarComubnicado');
    Route::post('enterado','ComunicadosController@enterado');
    Route::post('enteradousuarios','ComunicadosController@enteradousuarios');
});

Route::prefix('Areas')->group(function(){
    Route::post('getareas','AreaController@obtenerArea');
    Route::post('postareas','AreaController@insertarArea');
    Route::post('eliminarareas','AreaController@eliminarArea');
});

Route::prefix('CategoriaPublicacion')->group(function(){
    Route::post('getcatpub','CategoriaPublicacionController@obtenerCatPub');
    Route::post('postcatpub','CategoriaPublicacionController@insertarCatPub');
    Route::post('eliminarcatpub','CategoriaPublicacionController@eliminarCatPub');
});

Route::prefix('Estados')->group(function(){
    Route::post('getestados','EstadosController@obtenerEstado');
    Route::post('postestados','EstadosController@insertarEstado');
    Route::post('eliminarestados','EstadosController@eliminarEstado');
    Route::post('getMarcacion','EstadosController@getMarcacion');
});

Route::prefix('LinkInteres')->group(function(){
    Route::post('getli','LinksInteresController@obtenerLi');
    Route::post('postli','LinksInteresController@insertarLi');
    Route::post('eliminarli','LinksInteresController@eliminarLi');
});
//Rutas del usuario BackEnd
Route::prefix('Usuarios')->group(function(){
    Route::post('postusuarios','UsuariosController@insertarUsuario');
    Route::post('getusuarios','UsuariosController@obtenerUsuario');
    Route::post('getusuariosestadocero','UsuariosController@obEstadoUsuarioCero');
    Route::post('postCargo','UsuariosController@postCargo');
    Route::post('getCargo','UsuariosController@getCargo');
    Route::post('deleteCargo','UsuariosController@deleteCargo');
    Route::post('Login','UsuariosController@Login');

    //mensajes
    Route::post('getMensajes','MensajesController@getMensajes');
    Route::post('postMensajes','MensajesController@postMensajes');

});

Route::prefix('CategoriaNoticia')->group(function(){
    Route::post('getcategorianoticia','CategoriaNoticiaController@obtenerCatNoticia');
    Route::post('postcategorianoticia','CategoriaNoticiaController@insertarCatNoticia');
    Route::post('eliminarcategorianoticia','CategoriaNoticiaController@eliminarCatNoticia');
});


Route::prefix('Noticias')->group(function(){
    Route::post('getNoticias','NoticiasController@getNoticias');
    Route::post('postNoticias','NoticiasController@postNoticias');
    Route::post('deleteNoticias','NoticiasController@deleteNoticias');

    Route::post('getComentarios','NoticiasController@getComentarios');
    Route::post('postComentarios','NoticiasController@postComentarios');

    Route::post('getRecomendacion','NoticiasController@getRecomendacion');
    Route::post('postRecomendacion','NoticiasController@postRecomendacion');
});

Route::prefix('Eventos')->group(function(){
    Route::post('geteventos','eventosController@geteventos');
    Route::post('posteventos','eventosController@posteventos');
    Route::post('deleteEventos','eventosController@deleteEventos');

    Route::post('getComentarios','eventosController@getComentarios');
    Route::post('postComentarios','eventosController@postComentarios');

    Route::post('getRecomendacion','eventosController@getRecomendacion');
    Route::post('postRecomendacion','eventosController@postRecomendacion');
});

Route::prefix('Galeria')->group(function(){
    Route::post('getFiles','subirImagenesController@getFiles');
    Route::post('getAlbum','subirImagenesController@deletealbum');
    Route::post('postalbum','subirImagenesController@postalbum');
    Route::post('getAlbum','subirImagenesController@getAlbum');

    Route::post('subidaFicheros','subirImagenesController@subidaFicheros');
    Route::post('subidaFicheros','subirImagenesController@subidaFicheros');

    Route::post('subidaFicheros','subirImagenesController@subidaFicheros');
    Route::post('deleteFicheros','subirImagenesController@deleteFicheros');
});

//Rutas del Correos Personales BackEnd
Route::prefix('CorreosPersonales')->group(function(){
    Route::post('postcorreopersonal','CorreosPersonalesController@insertarCorreoPersonal');
    Route::post('getcorreospersonales','CorreosPersonalesController@obtenerCorreosPersonales');
    Route::post('deletecorreospersonal','CorreosPersonalesController@eliminarCorreosPersonal');
});

//Rutas del Asuntos BackEnd
Route::prefix('Asuntos')->group(function(){
    Route::post('postasunto','AsuntoController@insertarAsunto');
    Route::post('getasuntos','AsuntoController@obtenerAsuntos');
    Route::post('deleteasunto','AsuntoController@eliminarAsunto');
});

//Rutas de Sugerencias BackEnd
Route::prefix('Sugerencias')->group(function(){
    Route::post('postsugerencia','SugerenciasController@insertarSugerencia');
    Route::post('getsugerencias','SugerenciasController@obtenerSugerencias');
});

//Rutas de Solicitudes de vacaciones BackEnd
Route::prefix('SolicitudesVacaciones')->group(function(){
    Route::post('postsolicitudvacacion','SolicitudesVacionesController@insertarSolicitudVacacion');
    Route::post('getsolicitudesvacaciones','SolicitudesVacionesController@obtenerSolicitudesVacaciones');
});

//Rutas de control de entrada y salida BackEnd
Route::prefix('EntradaSalida')->group(function(){
    Route::post('postentrada','EntradaSalidaController@insertarEntrada');
    Route::post('postsalida','EntradaSalidaController@insertarSalida');
    Route::post('getregistro','EntradaSalidaController@obtenerRegistros');
});

//Rutas para las encuestas

Route::get('/getSurveyList', 'SurveyController@index');
Route::get('/getSurvey/{slug}', 'SurveyController@show');
Route::post('/addSurvey', 'SurveyController@store');
Route::post('/deleteSurvey', 'SurveyController@destroy');
Route::post('/addContents', 'ContentController@store');
Route::post('/addAnswers', 'AnswerController@store');
Route::get('/checkExistence/{slug}/{id}', 'RespondController@show');
Route::get('/getRespondList/{slug}', 'RespondController@index');
Route::post('/addRespond', 'RespondController@store');

Route::get('/obtenerSurv/{slug}', 'SurvController@obtenerSurv');

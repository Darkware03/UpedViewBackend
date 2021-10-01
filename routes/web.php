<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');


if (Auth::user()->id==48) {
     Route::get('/', 'HomeController@index')->name('home');
     Route::get('/user/{id}', 'RespondController@index');
 }else{
     return view('error');
 }
});*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/user/{id}', 'RespondController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('img', function () {
    return view('sample');
});
Route::get('wxm', function () {
    $message['user'] = "Juan Perez";
    $message['message'] =  "jajaj";
    $success = event(new App\Events\Publicaciones($message));
    echo 'yeah yeah yeah';
});
Route::get('xample', function () {
    $id =  Auth::user()->id;
    echo $id;
});

/*
Aquí empieza lo de las encuentas
*/

Route::group(['middleware' => ['auth']], function () {

    // Return auth user data
    Route::get('/me', function (Request $request) {
        return \Response::json([
            'data' => \Auth::user()
        ], 200);
    });

    Route::get('/polls', 'PollController@index');
    Route::get('/polls/{poll}', 'PollController@show');
    Route::post('/polls/{poll}/vote', 'PollController@vote');
    Route::post('/polls/create', 'PollController@store');
    Route::put('/polls/{poll}', 'PollController@saveOptions');
    Route::put('/polls/{poll}/suggestion', 'OptionRequestController@store');
    Route::put('/polls/{poll}/approve', 'OptionRequestController@approveOption');
    Route::patch('/polls/{poll}/edit', 'PollController@update');
    Route::delete('/polls/{poll}', 'PollController@destroy');
    Route::get('/notificacion', 'Notificaciones@sendMessage');

    Route::get('/{any}', function () {
        return view('home');
    })->where('any', '.*');
});


Route::get('/new_survey', function () {

    if(Auth::user()) {

        return view('new_survey', [
            'token' => updateToken()
        ]);

    } else {

        return abort(403);
    }
})->name('new_survey');
Route::get('/sondeo/{path}', function ($path) {

    try {
        $survey = Survey::where('slug', '=', $path)->firstOrFail();

        return view('app');

    } catch(ModelNotFoundException $e) {

        return abort(404);
    }
});
Route::get('/edit/{path}', function ($path) {

    try {
        $survey = Survey::where('slug', '=', $path)->firstOrFail();

        if(Auth::user()->type === "admin") {

            return view('edit_survey', [
                'token' => updateToken(),
            ]);

        } else {

            return abort(403);
        }

    } catch(ModelNotFoundException $e) {

        return abort(404);
    }
});

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('your_receiver_email@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});
/*
Aquí termina lo de las encuentas
*/

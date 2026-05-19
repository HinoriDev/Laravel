<?php

use App\Http\Controllers\EntrarController;
use App\Http\Controllers\EpisodiosController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TemporadasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/series', [SeriesController::class, 'listarSeries'])->name('listar_series');
Route::get('/series/criar', [SeriesController::class, 'create'])->name('form_criar_serie') ->middleware('autenticador');
Route::post('/series/criar', [SeriesController::class, 'store'])->middleware('autenticador');
Route::delete('/series/{id}', [SeriesController::class, 'destroy'])->middleware('autenticador'); 
Route::post('/series/{id}/editaNome', [SeriesController::class, 'editaNome'])->middleware('autenticador');

Route::get('/series/{serieId}/temporadas', [TemporadasController::class, 'index']);

Route::get('/temporadas/{temporada}/episodios', [EpisodiosController::class, 'index']);
Route::post('/temporadas/{temporada}/episodios/assistir', [EpisodiosController::class, 'assistir']) ->middleware('autenticador');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/entrar', [EntrarController::class, 'index']);
Route::post('/entrar', [EntrarController::class, 'entrar']);
Route::get('/registrar', [RegistroController::class, 'create']);
Route::post('/registrar', [RegistroController::class, 'store']);

Route::get('/sair', function () {
    Auth::logout();
    return redirect('/entrar');
});

Route::get('/visualizando-email', function () {
    return new App\Mail\NovaSerie(
        'Arrow',
        5,
        10
    );
});

Route::get('/enviando-email', function () {
        $email = new App\Mail\NovaSerie(
        'Arrow',
        5,
        10
    );

    $email->subject('Nova série adicionada!');
    
    $user = (object) [
        'email' => 'hinori@teste.com',
        'name' => 'hinori'
        ];

    \Illuminate\Support\Facades\Mail::to($user)->send($email);
    return 'Email enviado!';
});

Route::get('/buscareresEmJson', function () {
    return App\Models\Serie::all();
});
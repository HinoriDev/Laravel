<?php

use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/clients', [ClientsController::class, 'index'])->name('clients.all');
Route::get('/create_file', [ClientsController::class, 'createFile'])->name('create.file');
Route::get('/list_files', [ClientsController::class, 'listFiles'])->name('list.files');
Route::get('/delete_all_files', [ClientsController::class, 'deleteFiles'])->name('delete.files');

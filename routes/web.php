<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MicrosoftController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HandleMailsController;
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

Route::get('/', function () {
    return view('welcome');
})->name('/');

//rutas de autenticacion con microsoft
Route::get('auth/redirect', [MicrosoftController::class, 'redirectMicrosoft']);
Route::get('auth/callback', [MicrosoftController::class, 'callbackMicrosoft']);
Route::get('logout', [MicrosoftController::class, 'logout']);


//ruta del formulario

Route::get('form', [FormController::class, 'renderForm'])->middleware('auth');

//ruta de la consulta de correos en imap

Route::get('mails/all', [HandleMailsController::class, 'getAllMails']);


//ruta de monitoreo de correos



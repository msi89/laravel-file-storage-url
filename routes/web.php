<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ImageController;
use App\Services\ImagePathGenerator;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/documents/{path}', [DocumentController::class, 'show']);
Route::get('/images/{path}', [ImageController::class, 'show']);

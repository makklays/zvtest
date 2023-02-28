<?php
/**
 * author: Alexander Kuziv
 * e-mail: hola.kuziv@gmail.com
 *  fecha: 28-02-2023 
 */

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

Route::get('/', function () {
    return view('welcome');
});

// páginas
Route::get('rankings', [App\Http\Controllers\RankingController::class, 'rankings'])->name('rankings');


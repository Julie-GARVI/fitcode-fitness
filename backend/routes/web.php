<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExerciceController;

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

Route::get('/login', function () {
    return view('login');
});

Route::post('/login/admin', [AdminController::class, 'loginAdmin']);

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/exercices', function () {
        $exercices = [];
        return view('exercices', ['exercices' => $exercices]);
    });

});

Route::get('/exercices/admin', [ExerciceController::class, 'list'])->name('exercices.admin');






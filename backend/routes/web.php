<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminExerciceController;
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

//-----------------------------Routes du backOffice-------------------------
Route::get('/', function () {
    return view('login');
});

Route::post('/login/admin', [AdminController::class, 'loginAdmin']);


Route::middleware(['auth', 'role:Admin'])->group(function () {

    Route::get('exercices/admin', function () {

        return view('exercices');
    });

    Route::get('/exercices/admin/add', function () {
        return view('exercices-add');
    });

    Route::get('/exercices/admin/edit', function () {
        return view('exercices-edit');
    });

    Route::get('/exercices/admin', [AdminExerciceController::class, 'listExercices']);

    Route::post('/exercices/add', [AdminExerciceController::class, 'createExercices']);

    Route::put('/exercices/edit', [AdminExerciceController::class, 'updateExercices']);

    Route::delete('/exercices/{id}', [AdminExerciceController::class, 'deleteExercice']);

});








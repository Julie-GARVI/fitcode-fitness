<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminExerciceController;
use App\Http\Controllers\ContactController;
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

    Route::get('/exercices/admin', function () {

        return view('exercices');
    });

    Route::get('/exercices/admin/add', function () {
        return view('exercices-add');
    });

    Route::get('/exercices/admin/edit/{id}', function () {
        return view('exercice-edit');
    });

    Route::get('/exercices/admin/edit/{id}', [AdminExerciceController::class, 'showExerciceId']);

    Route::get('/exercices/admin', [AdminExerciceController::class, 'listExercices'])->name('exercices.members');

    Route::post('/exercices/add', [AdminExerciceController::class, 'createExercices']);

    Route::put('/exercices/edit/{id}', [AdminExerciceController::class, 'updateExercices']);

    Route::delete('/exercices/{id}', [AdminExerciceController::class, 'deleteExercice']);

    Route::get('/contact', function () {
        return view('contact');
    });

    Route::get('/contact', [ContactController::class, 'list']);

    Route::post('/logout', [AdminController::class, 'logoutAdmin'])->name('logout.admin');


});








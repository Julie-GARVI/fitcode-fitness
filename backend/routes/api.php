<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
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


// Création des routes avec la méthode appropriée :
// - Get pour récupérer des données
// - Post pour ajouter des données
// - Put pour modifier des donnéesController::class, 'list']);
// - Delete pour supprimer des données

// Les controlleurs et les méthodes sont nommés dans les routes



// -----------------------------------------Routes publiques--------------------------------__

    Route::get('/teams', [UserController::class, 'list']);

    Route::get('/comments', [CommentController::class, 'list'])->name('comments.home');

    Route::post('/auth/register', [UserController::class, 'createUser']);

    Route::post('/auth/login', [UserController::class, 'loginUser'])->name('login');

    Route::post('/contact', [ContactController::class, 'create']);

    Route::get('/categories', [CategoryController::class, 'list']);

    Route::get('/users/{user}/categories', [CategoryController::class, 'listUserCategories']);

// ----------------------------------------Routes privées--------------------------------__

// Le middleware permet de rendre privé l'accès aux exercices

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/members/{id}', [UserController::class, 'show']);

    Route::get('/exercices/coach/{id}', [ExerciceController::class, 'show'])->name('exercice.coach');

    Route::get('exercices/member/{id}', [ExerciceController::class, 'show'])->name('exercice.member');

    Route::get('/exercices/coachs', [ExerciceController::class, 'list'])->name('exercices.coachs');

    Route::get('/exercices/members', [ExerciceController::class, 'list'])->name('exercices.members');

    Route::get('/multimedias', [MultimediaController::class, 'list']);

    Route::get('exercice/{id}/comments', [CommentController::class, 'list'])->name('comments.exercice');

    Route::post('/exercices', [ExerciceController::class, 'create']);

    Route::post('/auth/logout', [UserController::class, 'logout'])->name('logout');

    Route::post('/exercice/{id}/comments', [CommentController::class, 'create']);

    Route::put('/exercices/{id}', [ExerciceController::class, 'update']);

    Route::delete('/exercices/{id}', [ExerciceController::class, 'delete']);

    Route::delete('/exercice/{id}/comment', [CommentController::class, 'delete']);

});

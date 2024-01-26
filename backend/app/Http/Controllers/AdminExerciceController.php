<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExerciceController;
use Illuminate\Http\Request;
use App\Models\Exercice;
use Illuminate\Support\Facades\Auth;


class AdminExerciceController extends ExerciceController
{
    public function listExercices(Request $request)
        {
            $exercices = $this->listAllExercices($request);

            return view('exercices', ['exercices' => $exercices]);
        }
    }



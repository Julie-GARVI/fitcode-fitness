<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExerciceController;
use Illuminate\Http\Request;


class AdminExerciceController extends ExerciceController
{
    public function list(Request $request)
        {
            $exercices = $this->listAllExercices($request);

            foreach ($exercices as $exercice) {
                $exercice->user->multimedia;
            }

            //return $exercices;

            return view('exercices', ['exercices' => $exercices]);
        }
    }



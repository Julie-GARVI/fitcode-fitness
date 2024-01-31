<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExerciceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;


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

        public function createl(Request $request)
        {
            $exercice = $this->create($request);

            return redirect('exercices/admin');

            return $exercice;
        }
    }

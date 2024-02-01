<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExerciceController;
use Illuminate\Http\Request;
use App\Models\Exercice;


class AdminExerciceController extends ExerciceController
{

    public function listExercices(Request $request)
        {
            $exercices = $this->listAllExercices($request);

            foreach ($exercices as $exercice) {
                $exercice->user->multimedia;
            }

            //return $exercices;

            return view('exercices', ['exercices' => $exercices]);
        }


    public function createExercices(Request $request)
    {
        $exercice = $this->create($request);

        return redirect('exercices/admin');

        return $exercice;
    }


    protected function deleteExercice($id)
    {
        $exercice = Exercice::find($id);

        $exercice->delete();

        return response()->json(['message' => 'Exercice deleted']);
    }
}


<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExerciceController;
use Illuminate\Http\Request;
use App\Models\Exercice;


class AdminExerciceController extends ExerciceController
{

    public function showExerciceId(int $id)
    {
        $exercice = Exercice::findOrFail($id);

        return view('exercice-edit', ['exercice' => $exercice]);
    }

    public function listExercices(Request $request)
    {
        $exercices = $this->listAllExercices($request);

        foreach ($exercices as $exercice) {
            $exercice->user->multimedia;
            $exercice->user->category;
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


     public function updateExercices(Request $request, int $id)
     {
        $exercice = $this->update($request, $id);

        return redirect('exercices/admin');
     }

    public function deleteExercice($id)
    {
        $exercice = Exercice::find($id);

        $exercice->delete();

        return response()->json(['message' => 'Exercice deleted']);
    }


}


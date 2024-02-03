<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExerciceController;
use Illuminate\Http\Request;
use App\Models\Exercice;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


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
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['sometimes', 'regex:' . $this->regex ],
                'time' => ['sometimes'],
                'instructions' => 'sometimes',
                'level' => 'sometimes'
                //'category_id' => ['sometimes'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $request->validate([
                'name' => ['sometimes'],
                'time' => ['sometimes'],
                'instructions' => ['sometimes'],
                'level' => ['sometimes'],
                //'category_id' => ['sometimes'],
            ]);

            } catch (ValidationException $error) {
            return $error;
            }

            $exercice = Exercice::find($id);

            dd($exercice);

            if ($exercice && $exercice->user_id === Auth::id()) {
                $exercice->name = $request->input('name');
                $exercice->time = $request->input('time');
                $exercice->level= $request->input('level');
                $exercice->instructions = $request->input('instructions');
                //$exercice->category_id = $request->input('category_id');
                $exercice->save();

                return $exercice;
            } else {
                return response()->json([
                    'message' => 'Access not authorized'
                ], 401);
            }
     }

    public function deleteExercice($id)
    {
        $exercice = Exercice::find($id);

        $exercice->delete();

        return response()->json(['message' => 'Exercice deleted']);
    }


}


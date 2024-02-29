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
        $exercices = $this->list($request);

        return view('exercices', ['exercices' => $exercices]);
    }

    public function createExercices(Request $request)
    {
        $response = $this->create($request);
   
        if ($response->getStatusCode() === 201) {

            return redirect('exercices/admin');
            
        } else {
      
            return redirect()->back()->withErrors($response->getData()->errors);
        }

        return $exercice;
     }


     public function updateExercices(Request $request, int $id)
     {
        $response = $this->update($request, $id);
        
        if ($response->getStatusCode() === 200) {

            return redirect('exercices/admin');
            
        } else {
      
            return redirect()->back()->withErrors($response->getData()->errors);
        }
     }

    public function deleteExercice($id)
    {
        $exercice = Exercice::find($id);

        $exercice->delete();

        return response()->json(['message' => 'Exercice deleted']);
    }


}


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

        $userId = $id ?? Auth::id();

        $user = Auth::user();
        $userId = $user->id;

        //-----------------------EXERCICES DES ADMINS------------------------
            $userExercices = Exercice::where('user_id', $userId)->get();

            $commonList = $this->list($request);

            $exercices = $commonList ? $commonList->merge($userExercices) : $userExercices;

            foreach ($exercices as $exercice) {
                $timeValue = $exercice->time;
                //Scinde une chaîne de caractères en segments
                list($hours, $minutes, $seconds) = explode(':', $timeValue);
                //retourne une chaine formatée
                $formattedTime = sprintf('%d h, %d mins et %d s', $hours, $minutes, $seconds);
                $exercice->formatted_time = $formattedTime;
                //associé l'exercie à sa catégorie et son image
                $exercice->user;
                $exercice->category;
                $exercice->multimedia;
            }
            //return $exercices;

            //dd($exercices);

            return view('exercices', ['exercices' => $exercices]);
        }

    }


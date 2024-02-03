<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\Exercice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class ExerciceController extends Controller
{

   // --------------------RECUPERATION D'UN EXERCICE-------------------------
    public function show(int $id, Request $request)
    {

// --------------------EXERCICE D'UN MEMBRE-------------------------
    if ($request->routeIs('exercice.member')) {
         //On cible l'id de l'utilisateur connecté
        $user = Auth::user();
        $userId = $user->id;
        $exercices = Exercice::where('user_id', $userId)
                              ->with('category', 'multimedia', 'user')->findOrFail($id);


        return $exercices;
    }

// --------------------EXERCICE D'UN COACH-------------------------
    // Ajouter cette requette dans la fonction show
    if ($request->routeIs('exercice.coach')) {

        $exercices = Exercice::with('category', 'multimedia', 'user')->findOrFail($id);

        return $exercices;
    }
}


//--------------FONCTION AVEC HERITAGE-------------------------
//------------Récupération des exercices des coachs----------------------
    protected function listAllExercices(Request $request)
    {
        // On cible l'id de l'utilisateur connecté
    $user = Auth::user();
    $userId = $user->id;

    // --------------------EXERCICE DES MEMBRES-------------------------
        $exercices = Exercice::where('user_id', $userId)->get();

        foreach ($exercices as $exercice) {
            $timeValue = $exercice->time;
            // Scinde une chaîne de caractères en segments
            list($hours, $minutes, $seconds) = explode(':', $timeValue);
            // Retourne une chaine formatée
            $formattedTime = sprintf('%d h, %d mins et %d s', $hours, $minutes, $seconds);
            $exercice->formatted_time = $formattedTime;
            // Associé l'exercice à sa catégorie et son image
            $exercice->category;
            $exercice->multimedia;
        }

        return $exercices;
}



// --------------------EXERCICE DE TOUS LES UTILISATEURS------------------------
    public function list(Request $request)
    {
// --------------------EXERCICE DES MEMBRES-------------------------
            // --------------------EXERCICE DES MEMBRES-------------------------
        if ($request->routeIs('exercices.members')) {

            return $this->listAllExercices($request);
        }


// --------------------EXERCICE DES COACHS-------------------------
       //S'il s'agit des exercices des coachs
        if ($request->routeIs('exercices.coachs')) {

        //Création d'une jointure entre les tables exercices et users
        //on lie user_id de la table exercices avec l'id de la table users
            $exercices = Exercice::leftJoin('users', 'users.id', '=', 'exercices.user_id')
        //Le rôle doit être coach
                ->where('users.role', 'ADMIN')
                ->select('exercices.*')
                ->get();

                foreach ($exercices as $exercice) {
                    $timeValue = $exercice->time;
                //Scinde une chaîne de caractères en segments
                    list($hours, $minutes, $seconds) = explode(':', $timeValue);
                //retourne une chaine formatée
                    $formattedTime = sprintf('%d h, %d mins et %d s', $hours, $minutes, $seconds);
                    $exercice->formatted_time = $formattedTime;
                    //associé l'exercie à sa catégorie et son image
                    $exercice->category;
                    $exercice->multimedia;
                }

                return $exercices;
        }
    }


// --------------------CREATION DES EXERCICES-------------------------
    protected function create(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;

    try {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:' . $this->regex],
            'time' => 'required',
            'level' => 'sometimes',
            'instructions' => ['required', 'regex:' . $this->regex],
            'category_id' => 'sometimes',
        ]);


        $validator->validate();
    } catch (ValidationException $error) {
        return response()->json(['errors' => $error->errors()], 400);
    }

        $exercice = new Exercice();
        $exercice->user_id = $userId;
        $exercice->name = $request->input('name');
        $exercice->time = $request->input('time');
        $exercice->instructions = $request->input('instructions');

    if ($userId > 4) {
        $exercice->category_id = $request->input('category_id');
        }

    else {
        $exercice->category_id = $user->category_id;
        $exercice->level =  $request->input('level');
        $exercice->multimedia_id =  $request->input('multimedia_id');
    }

        if ($exercice->multimedia_id === null) {
           $exercice->multimedia_id = 9;
        }

        $exercice->save();

        return $exercice;
    }



// --------------------MODIFICATION DES ECERCICES-------------------------
    protected function update(Request $request, int $id)
{
    try {

    $user = Auth::user();
    $userId = $user->id;

    $validator = Validator::make($request->all(), [
        'name' => ['sometimes', 'regex:' . $this->regex ],
        'time' => ['sometimes'],
        'instructions' => 'sometimes',
        'category_id' => ['sometimes'],
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $request->validate([
        'name' => ['sometimes'],
        'time' => ['sometimes'],
        'instructions' => ['sometimes'],
        'level' => ['sometimes'],
        'category_id' => ['sometimes'],
    ]);

    } catch (ValidationException $error) {
    return $error;
    }

    $exercice = Exercice::find($id);

    if ($exercice && $exercice->user_id === Auth::id()) {
        $exercice->name = $request->input('name');
        $exercice->time = $request->input('time');
        $exercice->instructions = $request->input('instructions');

        if ($userId > 4) {
        $exercice->category_id = $request->input('category_id');
        } else {
        $exercice->level = $request->input('level');
        }
        $exercice->save();

        return $exercice;
    } else {
        return response()->json([
            'message' => 'Access not authorized'
        ], 401);
    }
}



// --------------------SUPRESSION DES ECERCICES-------------------------
    protected function delete($id)
    {
        $exercice = Exercice::find($id);

        $exercice->delete();

        return response()->json(['message' => 'Exercice deleted']);
    }
}

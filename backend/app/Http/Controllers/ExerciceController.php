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
        if ($request->routeIs('exercice.member')) {
            $user = Auth::user();
            $userId = $user->id;
            $exercices = Exercice::where('user_id', $userId)->findOrFail($id);
            
        } else {
            $exercices = Exercice::with('category', 'multimedia', 'user')->findOrFail($id);
        }

        return $exercices;
    }


// --------------------EXERCICE DE TOUS LES UTILISATEURS------------------------
    protected function list(Request $request)
    {
// --------------------EXERCICE DES MEMBRES-------------------------
        if ($request->routeIs('exercices.members')) {

            $user = Auth::user();
            $userId = $user->id;
            $exercices = Exercice::where('user_id', $userId)->get();
        }

// --------------------EXERCICE DES COACHS-------------------------
        else if (($request->routeIs('exercices.coachs')) ) {

            $exercices = Exercice::join('users', 'users.id', '=', 'exercices.user_id')
                ->where('users.role', 'ADMIN')
                ->select('exercices.*')
                ->get();
            }

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
            $exercice->user;
        }

        return $exercices;
    }



// --------------------CREATION DES EXERCICES-------------------------
protected function create(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    $userRole = $user->role;

    try {
        $rules = [
            'name' => ['required', 'regex:' . $this->regex],
            'time' => 'required',
            'level' => 'sometimes',
            'instructions' => ['required', 'regex:' . $this->regex],
        ];
        
        if ($userRole === "Membre") {
            $rules['category_id'] = ['required', 'int'];

        } else if ($userRole === "Admin") {
 
            $rules['level'] = 'required';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        $requiredMessages = requiredErrorMessages();
        $charactersMessages = $this->specialCharactersErrors();

        $validator->setCustomMessages(array_merge(
            $requiredMessages, 
            ['regex' => $charactersMessages['regex']],
        ));

        if (!$validator->fails()) {

            $exerciceData = $validator->validate();

            $exercice = new Exercice();
            $exercice->user_id = $userId;
            $exercice->name = $request->input('name');
            $exercice->time = $request->input('time');
            $exercice->instructions = $request->input('instructions');
            $exercice->category_id = $request->input('category_id');

            if ($userRole === "Admin") {
                $exercice->level =  $request->input('level');
                $exercice->multimedia_id =  $request->input('multimedia_id');
            }
        
            if ($exercice->multimedia_id === null) {
                $exercice->multimedia_id = 9;
            }

            $exercice->save();

            return response()->json([
                'message' => 'Exercice créé avec succès',
                'exercice' => $exercice,
            ], 201);

        } else {
            
            $errors = $validator->errors()->messages();
        
            return response()->json(['errors' => $errors], 422);
        }

    return $exercice;

    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
    }
}

// --------------------MODIFICATION DES ECERCICES-------------------------
protected function update(Request $request, int $id)
{
    try {
        $user = Auth::user();
        $userId = $user->id;
        $userRole = $user->role;

        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'regex:' . $this->regex],
            'time' => ['sometimes'],
            'level' => ['sometimes'],
            'instructions' => ['sometimes', 'regex:' . $this->regex],
            'category_id' => ['sometimes'],
        ]);

        $charactersMessages = $this->specialCharactersErrors();
        $validator->setCustomMessages(array_merge(
            ['regex' => $charactersMessages['regex']],
        ));

        $exercice = Exercice::find($id);

        if (!$validator->fails() && $exercice->user_id === Auth::id()) {
            $request->validate([
                'name' => ['sometimes'],
                'time' => ['sometimes'],
                'instructions' => ['sometimes'],
                'level' => ['sometimes'],
                'category_id' => ['sometimes'],
            ]);
    
            $exercice->name = $request->input('name');
            $exercice->time = $request->input('time');
            $exercice->instructions = $request->input('instructions');
    
            if ($userRole === "Membre") {
                $exercice->category_id = $request->input('category_id');
            } else if ($userRole === "Admin") {
                $exercice->level = $request->input('level');
            }

            $exercice->save();
                
            return response()->json([
                'message' => 'Exercice modifié avec succès',
                'exercice' => $exercice,
            ], 200);
        }

        else {
            $errors = $validator->errors()->messages();
            return response()->json(['errors' => $errors], 422);
        }

            return $exercice;

        } catch (\Throwable $th) {
            
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
    }
}


// --------------------SUPRESSION DES EXERCICES-------------------------
    protected function delete($id)
    {
        $exercice = Exercice::find($id);

        if ($exercice->user_id === Auth::id()) {

            $exercice->delete();
        }

        return response()->json(['message' => 'Exercice deleted']);
    }
}

//-------------------------------------------ERREURS--------------------------------------
function requiredErrorMessages() {
    return [
        'name.required' => 'Veuillez indiquer le nom de votre exercice',
        'time.required' => 'Veuillez indiquer le temps de votre exercice en heure(s), minute(s) et secondes',
        'instructions.required' => 'Veuillez indiquer les instructions de votre exercice',
        'category_id.required' => 'Veuillez indiquer la catégorie de votre exercice',
        'level.required' => 'Veuillez indiquer votre niveau',
    ];
}
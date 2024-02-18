<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{

// --------------------PROFIL UTILISATEUR-------------------------
    public function show(int $id) {

        $user = Auth::user();
        //$userId = $user->id
        $member = User::findOrFail($id);

        return response()->json($member);

        }


// --------------------EQUIPE DE COACH--------------------------
        public function list()
        {
            $role= 'Admin';
            $users = User::where('role', $role)->get();

            //foreach recupere les user et on rajoute dans les user les categorie et multimedia
             foreach ($users as $user) {
                 $user->categories;
                 $user->multimedia;
             }
            return $users;
        }



// -------------------CREATION UTILISATEUR--------------------------

public function createUser(Request $request)
{
    try {

        // Validation des données
        $validateUser = Validator::make($request->all(), [
            'gender' => 'required',
            'lastname' => ['required', 'max:50', 'string', 'regex:' . $this->regex ],
            'firstname' => ['required', 'max:50', 'string', 'regex:' . $this->regex],
            'age' => ['required', 'min:12', 'max:90', 'integer'],
            'email' => ['required', 'email', 'unique:users', 'regex:' . $this->regex],
            'password' => ['required', 'min:8', 'regex:' . $this->passwordRegex],
            'category_id' => 'sometimes',
            'level' => 'sometimes',
        ]);

         // Récupération des messages d'erreur personnalisés
         $customMessages = customErrorMessages();

         // Application des messages d'erreur personnalisés
         $validateUser->setCustomMessages($customMessages);

        if ($validateUser->fails()) {

            $errors = $validateUser->errors();

            // Construction du tableau des erreurs personnalisées
            $responseErrors = $errors->messages();

            return response()->json(['errors' => $responseErrors], 401);
        }

        $number = null;
        do {
            $number = mt_rand(10000, 99999);
        }while (User::where('number', $number)->exists());


    //Création de l'utilisateur
        $userData = $request->except('category_id');
    //Rôle par défaut
        $userData['role'] = 'Membre';
    //Hachage du mot de passe
        $userData['password'] = Hash::make($userData['password']);
    //Attribution du n° d'adhérent
        $userData['number'] = $number;

        $user = User::create($userData);
        $category_id = $request->input('category_id');
    // Création de la relation many-to-many avec la table catégorie
        $user->categories()->attach($category_id);

        $token = $this->createToken($user, 'token');

    // Réponse en JSON
        return response()->json([
            'isAuthenticate' => true,
            'number' => $user->number,
            'token' =>  $token['token'], 
            'expiration' => $token['expiration'], 
            'id' => $user->id,
        ], 200);

    // Retour en cas d'erreur
    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
    }
}



// -------------------CONNEXION UTILISATEUR--------------------------
protected function loginUser(Request $request)
{
    try {
        // Valide les données de l'utilisateur
        $validateUser = Validator::make($request->all(), [
            'email' => ['required', 'email', 'regex:' . $this->regex],
            'password' => ['required', 'min:8', 'regex:' . $this->passwordRegex],
        ]);

            $validateUser->setMessages(customErrorMessages());

            if ($validator->fails()) {
                // Construction de la réponse JSON avec les erreurs et la durée d'affichage
                $response = [
                    'errors' => $validator->errors(),
                    'displayDuration' => 5000 // 5 secondes
                ];
    
                return response()->json($response, 401);
            }

            // Tente de connecter l'utilisateur
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                Session::put('user', $user);

                $token = $this->createToken($user, 'token');

                return response()->json([
                    'message' => 'Connection successful',
                    'id' => $user->id,
                    'token' =>  $token['token'], 
                    'expiration' => $token['expiration'], 
                    'isAuthenticated' => 'true',
                ], 200);

            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    // -------------------DECONNECTION UTILISATEUR--------------------------
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens->each(function (PersonalAccessToken $token) {
                $token->delete();
            });
        }

        return response()->json(['message' => 'Déconnexion réussie']);
    }

}


//----------------------------------------EURREURS---------------------------------

function customErrorMessages() {
    return [
        'gender.required' => 'Erreur ! Le genre est obligatoire.',
        'lastname.required' => 'Erreur ! Le nom de famille est obligatoire.',
        'firstname.required' => 'Erreur ! Le prénom est obligatoire.',
        'age.required' => 'Erreur ! L\'âge est obligatoire.',
        'email.required' => 'Erreur ! L\'email est obligatoire.',
        'password.required' => 'Erreur ! Le mot de passe est obligatoire.',
    ];
}

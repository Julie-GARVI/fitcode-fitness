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
                 $user->category;
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

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateUser->errors(),
            ], 401);
        }

        $number = null;
        do {
            $number = mt_rand(10000, 99999);
        }while (User::where('number', $number)->exists());


    //Création de l'utilisateur sans le catégory_id
        $userData = $request->except('category_id');
        $userData['role'] = 'Membre';
    //Hachage du mot de passe
        $userData['password'] = Hash::make($userData['password']);
        $userData['number'] = $number;

        $user = User::create($userData);
        $category_id = $request->input('category_id');
    // Création de la relation many-to-many avec la table users
        $user->categories()->attach($category_id);

        // Réponse en JSON
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'number' => $user->number,
            'token' => $user->createToken('API TOKEN')->plainTextToken,
            'expiration' => 300,
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

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            // Tente de connecter l'utilisateur
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                Session::put('user', $user);

                return response()->json([
                    'message' => 'Connection successful',
                    'id' => $user->id,
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
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



// -------------------CATEGORIES UTILISATEUR--------------------------
public function listUserCategories(User $user)
    {
    $categories = $user->categories;

    return response()->json($categories);
    }
}




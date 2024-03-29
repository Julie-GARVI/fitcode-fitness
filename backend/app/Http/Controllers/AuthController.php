<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
//use App\Mail\SendMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // -------------------CREATION UTILISATEUR--------------------------

    public function create(Request $request)
    {
        try {
    
            // Validation des données
            $validateUser = Validator::make($request->all(), [
                'gender' => 'required',
                'lastname' => ['required', 'max:50', 'string', 'regex:' . $this->regex ],
                'firstname' => ['required', 'max:50', 'string', 'regex:' . $this->regex],
                'age' => ['required', 'min:12', 'max:90', 'integer'],
                'email' => ['required', 'email', 'unique:users', 'regex:' . $this->regex],
                'password' => ['required', 'min:8', 'confirmed', 'regex:' . $this->passwordRegex],
                'category_id' => 'sometimes',
                'level' => 'required',
            ]);
    
            $requiredMessages = requiredErrorMessages();
            $validateMessages = validateErrorMessages();
            $charactersMessages = $this->specialCharactersErrors();
    
            $validateUser->setCustomMessages(array_merge(
                $requiredMessages, 
                $validateMessages,
                ['regex' => $charactersMessages['regex']],
                ['password.regex' => $charactersMessages['passwordRegex']]
            ));
    
            if ($validateUser->fails()) {
    
                $errors = $validateUser->errors()->messages();
            
                return response()->json(['errors' => $errors], 422);
            }
    
            else {
    
                $number = null;
                do {
                    $number = mt_rand(10000, 99999);
                }while (User::where('number', $number)->exists());
        
        
            //Validation requête
                $userData = $request->except('category_id');

            //Rôle par défaut
                $userData['role'] = 'Membre';

            //Attribution du n° d'adhérent
                 $userData['number'] = $number;

            //Attribution de la photo du user
                $userData['multimedia_id'] = ($userData['gender'] === "Femme") ? 10 :  11;
 
            //Hachage du mot de passe
                $userData['password'] = Hash::make($userData['password']);

            //Création de l'utilisateur
                $user = User::create($userData);

                $category_id = $request->input('category_id');

            //Envoie vers la table catégorie
                $user->categories()->attach($category_id);
        
            //Attribution du token
                $token = $this->createToken($user, 'token');
          
            // Réponse en JSON
                return response()->json([
                    'isAuthenticate' => true,
                    'number' => $user->number,
                    'token' =>  $token['token'], 
                    'expiration' => $token['expiration'], 
                    'id' => $user->id,
                ], 200);    
    
            }
    
            // Retour en cas d'erreur
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage(),
                ], 500);
            }
        }
    
//Mail::to($user->email)->send(new SendMail($user));


    // -------------------CONNEXION UTILISATEUR--------------------------
    protected function login(Request $request)
    {
    try {
        // Valide les données de l'utilisateur
        $validateUser = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        // Tente de connecter l'utilisateur
        $credentials = $request->only('email', 'password');

        $requiredMessages = requiredErrorMessages();

        $validateUser->setCustomMessages(array_merge(
            $requiredMessages
        ));

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            Session::put('user', $user);

            $token = $this->createToken($user, 'token');
            $csrfToken = csrf_token();

            return response()->json([
                'message' => 'Connection successful',
                'id' => $user->id,
                'token' =>  $token['token'],
                'expiration' => $token['expiration'],
                'isAuthenticated' => 'true',
            ], 200);
        }

        else if ($validateUser->fails()) {

            $errors = $validateUser->errors()->messages();
        
            return response()->json([
                'errors' => $errors], 422);
        }

        else if (!User::where('email', $credentials['email'])->exists()) {
        
            $errors = ['email' => 'L\'adresse email est incorrecte'];

            return response()->json([
                'errors' => $errors,
            ], 401);


        } else if (!User::where('password', $credentials['password'])->exists())  {
        
            $errors = ['password' => 'Le mot de passe est incorrect'];

            return response()->json([
                'errors' => $errors,
            ], 401);
        }

    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
    }
    }


    // -------------------DECONNECTION UTILISATEUR--------------------------
    protected function logout(Request $request)
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
    //----------------------------------------ERREURS---------------------------------

    function requiredErrorMessages() {
    return [
        'gender.required' => 'Veuillez indiquer votre genre',
        'lastname.required' => 'Veuillez indiquer votre nom de famille',
        'firstname.required' => 'Veuillez indiquer votre prénom',
        'age.required' => 'Veuillez indiquer votre âge',
        'email.required' => 'Veuillez indiquer votre adresse email',
        'password.required' => 'Veuillez indiquer votre mot de passe',
        'level.required' => 'Veuillez indiquer votre niveau',
    ];
    }

    function validateErrorMessages() {
    return [
        'lastname.max' => 'Votre nom de famille est trop long',
        'firstname.max' => 'Votre prénom est trop long',
        'age.min' => 'Vous devez avoir au minimum 12 ans',
        'age.max' => 'Vous devez avoir au maximum 90 ans',
        'email.email' => 'L\'adresse email doit inclure "@"',
        'email.unique' => 'L\'adresse email est déjà prise',
        'password.min' => 'Votre mot de passe doit avoir au minimum 8 caractères',
        'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ];
    }


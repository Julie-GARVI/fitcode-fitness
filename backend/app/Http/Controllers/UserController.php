<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

// --------------------PROFIL UTILISATEUR-------------------------
    public function show(int $id) {

        $user = Auth::user();
        //$userId = $user->id
        $member = User::with('multimedia')->findOrFail($id);

        return response()->json($member);

        }

// --------------------EQUIPE DE COACH--------------------------
        public function list()
        {
            $role= 'Admin';
            $users = User::where('role', $role)->get();

             foreach ($users as $user) {
                 $user->categories;
                 $user->multimedia;
             }
            return $users;
        }
}
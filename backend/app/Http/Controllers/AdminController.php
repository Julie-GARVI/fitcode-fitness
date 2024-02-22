<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

class AdminController extends UserController
{
    public function loginAdmin(Request $request)
    {
        $response = $this->loginUser($request);

        // Si le code de statut est 200, rediriger vers la page admin
        if ($response->getStatusCode() === 200) {
            return redirect('exercices/admin');
        }

        // Si le code de statut est autre que 200 ou 403, afficher les erreurs
        return view('login', [
            'errors' => $response->getData()->errors
        ]);
    }
}
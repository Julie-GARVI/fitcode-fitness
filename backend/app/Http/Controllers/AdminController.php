<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends UserController
{

    public function loginAdmin(Request $request)
    {
        $response = $this->loginUser($request);

        if ($response->getStatusCode() === 200) {

            $request->session()->regenerate();

            return redirect('exercices/admin');
            
        } else {
      
            return redirect()->back()->withErrors($response->getData()->errors);
        }
    }

    public function logoutAdmin(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}
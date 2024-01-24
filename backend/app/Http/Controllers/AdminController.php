<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;


class AdminController extends UserController
{
    public function loginAdmin(Request $request)
    {
        $response = $this->loginUsers($request);

        if ($response->getStatusCode() === 200) {
            return redirect('/private');
        }

        return $response;
    }
}


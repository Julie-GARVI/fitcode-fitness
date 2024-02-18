<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $regex;
    public $passwordRegex;

    public function __construct()
    {
        $this->regex = '/^[^#$%^&*\|{}<>~]+$/';
        ;
        $this->passwordRegex = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
    }

    public function createToken(User $user, string $tokenName)
    {
        $expiration = now()->addHours(1);
    
        $token = $user->createToken($tokenName, ['*'], $expiration);
    
        return [
            'token' => $token->plainTextToken,
            'expiration' => $expiration,
        ];
    }

}

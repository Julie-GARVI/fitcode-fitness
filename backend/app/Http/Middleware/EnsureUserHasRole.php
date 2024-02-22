<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->role === $role) {
            return $next($request);
        } else {
            return response()->view('login', [
                'errors' => ["Vous n'êtes pas autorisé à accéder à cette page"]
            ], 403);
        }
    }
}
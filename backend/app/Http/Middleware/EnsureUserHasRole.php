<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->role === $role) {
            return $next($request);
        } else {

            abort(403, "Vous n'êtes pas autorisé à accéder à cette page");
        }
    }
}
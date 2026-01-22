<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Member is anyone who is NOT admin and NOT vendor
        if ($user && !$user->isAdmin() && !$user->isVendor()) {
            return $next($request);
        }

        abort(403, 'Unauthorized access to member area');
    }
}

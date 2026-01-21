<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if user is authenticated and is a vendor
        if ($user && $user->isVendor()) {
            return $next($request);
        }

        abort(403, 'Unauthorized access to vendor panel');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  array<int, string>  $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || empty($roles)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (!$user->hasRole(...$roles)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}



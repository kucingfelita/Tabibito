<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserType
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, int ...$allowedTypes): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->tipe_user, $allowedTypes, true)) {
            abort(Response::HTTP_FORBIDDEN, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}

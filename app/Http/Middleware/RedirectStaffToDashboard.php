<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectStaffToDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $type = auth()->user()->tipe_user;
            
            if ($type == User::TYPE_ADMIN) {
                return redirect()->route('admin.dashboard');
            } elseif ($type == User::TYPE_OWNER) {
                return redirect()->route('owner.dashboard');
            } elseif ($type == User::TYPE_EMPLOYEE) {
                return redirect()->route('owner.scanner');
            }
        }

        return $next($request);
    }
}

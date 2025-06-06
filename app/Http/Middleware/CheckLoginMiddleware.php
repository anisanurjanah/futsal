<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::guard('web')->user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Kamu tidak memiliki akses.');
        }

        return $next($request);
    }
}

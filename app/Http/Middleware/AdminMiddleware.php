<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (!$user || !isset($user->is_admin) || $user->is_admin != 1) {
            abort(403, 'Unauthorized - admin only.');
        }
        return $next($request);
    }
}
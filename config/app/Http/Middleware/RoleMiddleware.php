<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $userRole = strtolower(session('user_role', ''));
        if ($userRole !== strtolower($role) && $userRole !== 'admin') {
            abort(403, 'Unauthorized. Required role: ' . $role);
        }
        return $next($request);
    }
}

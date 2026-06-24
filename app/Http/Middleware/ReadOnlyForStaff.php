<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReadOnlyForStaff
{
    // Resource actions that mutate data — blocked for staff
    protected array $blockedActions = ['create', 'store', 'edit', 'update', 'destroy'];

    public function handle(Request $request, Closure $next)
    {
        if (strtolower(session('user_role', '')) === 'staff') {
            $action = $request->route()?->getActionMethod();
            if (in_array($action, $this->blockedActions)) {
                abort(403, 'Staff accounts have read-only access. Contact an administrator to make changes.');
            }
        }
        return $next($request);
    }
}

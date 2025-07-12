<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = User::pluck('role');
        $user = json_decode(json_encode($user),true);
        
        if (!in_array('admin', $user)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

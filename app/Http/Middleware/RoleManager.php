<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Por favor, faça login para acessar esta página.');
        }

        $userRole = Auth::user()->role;
        $roleMap = [
            1 => 'admin',
            2 => 'vendor',
            3 => 'customer',
        ];

        $userRoleName = $roleMap[$userRole] ?? null;

        if ($userRoleName === $role) {
            return $next($request);
        }

        if ($userRoleName) {
            return redirect("/{$userRoleName}/dashboard")->with('error', 'Acesso não autorizado para esta área.');
        }

        return redirect('/')->with('error', 'Acesso não autorizado.');
    }
}

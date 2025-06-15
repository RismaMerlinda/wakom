<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles)) {
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/transaksi');
            } elseif ($user->role === 'pelanggan') {
                return redirect()->intended('/pesan');
            } elseif ($user->role === 'waiter') {
                return redirect()->intended('/waiter/orders');
            } elseif ($user->role === 'kasir') {
                return redirect()->intended('/kasir/orders');
            }
            return redirect()->intended('/login');
        }

        return $next($request);
    }
}

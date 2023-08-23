<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->check()) {
            return redirect('/admin/login');
        } else {
            if (auth()->check() && auth()->user()->role === 'super_admin') {
                if ($request->is('admin/login') || $request->is('admin')) {
                    return redirect('/admin/dashboard');
                } else {
                    return $next($request);
                }
            } else {
                return redirect('/');
            }
        }
    }
}

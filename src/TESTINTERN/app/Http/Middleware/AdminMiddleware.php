<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
        if (! $request->session()->has('admin')) return redirect()->route('admin.loginManagement');

        $result = $request->session()->get('admin');
        if (is_int($result['id']) && $result['id'] > 0 && is_int($result['role']) && $result['role'] >= 1 && $result['role'] <= 3) {
            return $next($request);
        }
        return redirect()->route('admin.loginManagement');
    }
}

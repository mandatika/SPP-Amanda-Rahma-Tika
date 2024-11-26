<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request):
     * (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allow = array_slice(func_get_args(), 2); // Check allowed roles

        if (\Auth::user()) { // If the user is logged in
            $ada = \Auth::user()->hasRole()->value('role');
            $role = $ada ? $ada : 'user';

            foreach ($allow as $allowRole) { // For each allowed role
                if ($role == $allowRole) {
                    return $next($request);
                }
            }
            return redirect('/dashboard');
        } else {
            return redirect('.');
        }
    }
}

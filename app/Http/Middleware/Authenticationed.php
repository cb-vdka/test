<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticationed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(session('user_id'))) {
            $roleId = session('user_role');
            if (in_array($roleId, [3, 16], true)) {
                return redirect()->route('teacher.teaching_schedule.index');
            } elseif ($roleId === 2) {
                return redirect()->route('schedule.index');
            }
            return redirect()->route('dashboard.index');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceSkill
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && (empty($user->skill) || empty($user->skill_level))) {
            // Hindari redirect loop jika sudah di halaman pilih skill
            if (!$request->routeIs('users.skills.choose') && !$request->routeIs('users.skills.save')) {
                return redirect()->route('users.skills.choose');
            }
        }
        return $next($request);
    }
}

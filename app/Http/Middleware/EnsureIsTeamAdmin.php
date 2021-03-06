<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsTeamAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        foreach ($user->teams as $team) {
            if ($team->id === intval($request->route('id')) && 1 === $team->pivot->admin) {
                return $next($request);
                exit;
            }
        }
        return response([
            'message' => ['Non admin du groupe']
        ], 401);
    }
}

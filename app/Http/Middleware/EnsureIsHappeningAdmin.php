<?php

namespace App\Http\Middleware;

use App\Models\Happening;
use Closure;
use Illuminate\Http\Request;

class EnsureIsHappeningAdmin
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
        $happening = Happening::find($request->route('id'));
        if (null === $happening) {
            return response([
                'message' => ['Happening inconnu']
            ], 404);
        }

        foreach ($user->teams as $team) {
            if ($team->id === $happening->team_id && 1 === $team->pivot->admin) {
                return $next($request);
                exit;
            }
        }
        return response([
            'message' => ['Non admin du groupe']
        ], 401);
    }
}

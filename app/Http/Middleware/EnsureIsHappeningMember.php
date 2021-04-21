<?php

namespace App\Http\Middleware;

use App\Models\Happening;
use Closure;
use Illuminate\Http\Request;

class EnsureIsHappeningMember
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
        $teams = $user->teams()->where('team_id', $happening->team_id)->get();
        if (0 === count($teams)) {
            return response([
                'message' => ['Non membre du groupe']
            ], 401);
        }
        return $next($request);
    }
}

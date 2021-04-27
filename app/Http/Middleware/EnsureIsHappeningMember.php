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
        foreach ($happening->users as $elem) {
            if ($user->id === $elem->id) {
                return $next($request);
                exit;
            }
        }

        return response([
            'message' => ["Non membre de l'évènement"]
        ], 401);
    }
}

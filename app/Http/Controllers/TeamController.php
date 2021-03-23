<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $team = Team::create([
            'name' => $request->name
        ]);
        $user = $request->user();

        $team->users()->attach($user->id);
        $team->users;

        return $team;
    }

    public function show($id)
    {
        $team = Team::find($id);
        if (null === $team) {
            return response([
                "message" => "Groupe inconnu"
            ], 404);
        }
        $team->users;

        return response($team, 200);
    }
}
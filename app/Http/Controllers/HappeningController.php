<?php

namespace App\Http\Controllers;

use App\Models\Happening;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class HappeningController extends Controller
{
    public function create(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
        ]);

        $happening = Happening::create([
            'name' => $request->name,
            'status_id' => $request->status,
            'description' => $request->description ?: '',
            'place' => $request->place ?: '',
            'team_id' => $id,
            'start_at' => new \DateTime($request->start_at),
            'end_at' => new \DateTime($request->end_at),
        ]);

        $team = Team::find($id);
        foreach ($team->users as $elem) {
            if (true === $elem->pivot->admin) {
                $happening->users()->attach($elem->id);
            }
        }

        $happening = Happening::find($happening->id);
        $happening->team;
        $happening->users;

        return $happening;
    }

    public function show($id)
    {
        $happening = Happening::find($id);
        if (null === $happening) {
            return response([
                'message' => ['Happening inconnu']
            ], 404);
        }
        $happening->team;
        $happening->users;

        return response($happening, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
        ]);
        $happening = Happening::find($id);
        if (null === $happening) {
            return response([
                'message' => ['Happening inconnu']
            ], 404);
        }

        $happening->name = $request->name;
        $happening->status_id = $request->status;
        $happening->description = $request->description ?: '';
        $happening->place = $request->place ?: '';
        $happening->start_at = new \DateTime($request->start_at);
        $happening->end_at = new \DateTime($request->end_at);

        $happening->save();

        $happening = Happening::find($happening->id);
        $happening->team;
        $happening->users;

        return response($happening, 200);
    }

    public function delete($id)
    {
        $happening = Happening::find($id);
        if (null === $happening) {
            return response([
                'message' => ['Happening inconnu']
            ], 404);
        }
        $happening->delete();

        return response([
            'message' => 'Happening supprimé'
        ], 200);
    }

    public function addMember (Request $request, $id) {
        $request->validate([
            'user_id' => 'required',
        ]);

        $happening = Happening::find($id);
        if (null === $happening) {
            return response([
                'message' => ['Happening inconnu']
            ], 404);
        }

        $user = User::find($request->user_id);
        if (null === $user) {
            return response([
                "message" => "Utilisateur inconnu"
            ], 404);
        }
        $happening->users()->attach($user->id);

        $happening->team;
        $happening->users;

        return $happening;
    }

    public function removeMember (Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $happening = Happening::find($id);
        if (null === $happening) {
            return response([
                'message' => ['Happening inconnu']
            ], 404);
        }

        $user = User::find($request->user_id);
        if (null === $user) {
            return response([
                "message" => "Utilisateur inconnu"
            ], 404);
        }
        $happening->users()->detach($user->id);

        $happening->team;
        $happening->users;

        return $happening;
    }

    public function updateMemberPresence(Request $request, $id)
    {
        $request->validate([
            'presence' => 'required',
        ]);

        $happening = Happening::find($id);
        if (null === $happening) {
            return response([
                'message' => ['Happening inconnu']
            ], 404);
        }

        $user = $request->user();
        $happening->users()->updateExistingPivot($user->id, [
            'presence' => $request->presence,
        ]);

        $happening = Happening::find($id);
        $happening->team;
        $happening->users;

        return $happening;
    }
}

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

        $team->users()->attach($user->id, ['admin' => true]);
        $team->users;
        $team->invitations;
        $team->happenings;

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
        $team->invitations;
        $team['upcomingHappenings'] = $team->happenings()->where('start', '>', new \DateTime())->get();

        return response($team, 200);
    }

    public function getTeamsByName($name)
    {
        return Team::where('name', 'like', '%' . $name . '%')->get();
    }

    public function delete($id)
    {
        $group = Team::find($id);
        if (null === $group) {
            return response([
                "message" => "Groupe inconnu"
            ], 404);
        }

        $group->delete();
        return response([
            'message' => 'Groupe supprimé'
        ], 200);
    }

    public function manageAdmin(Request $request, $id)
    {
        $request->validate([
            'memberId' => 'required',
            'admin' => 'required',
        ]);
        $team = Team::find($id);
        if (null === $team) {
            return response([
                "message" => "Groupe inconnu"
            ], 404);
        }

        $adminCount = 0;
        foreach ($team->users as $elem) {
            if (true === $elem->pivot->admin) {
                $adminCount++;
            }
        }
        if (2 > $adminCount && false === $request->admin) {
            return response([
                "message" => "Vous ne pouvez laisser un groupe sans admin"
            ], 403);
        }

        $team->users()->updateExistingPivot($request->memberId, [
            'admin' => $request->admin,
        ]);

        $team = Team::find($id);
        $team->users;
        $team->invitations;
        $team['upcomingHappenings'] = $team->happenings()->where('start', '>', new \DateTime())->get();

        return response($team, 200);
    }

    public function removeMember(Request $request, $id, $memberId)
    {
        $team = Team::find($id);
        if (null === $team) {
            return response([
                "message" => "Groupe inconnu"
            ], 404);
        }

        $user = $request->user();
        if ($user->id === $memberId) {
            return response([
                "message" => "Vous ne pouvez vous supprimer vous-même. Utilisez la fonction 'Quitter'"
            ], 403);
        }

        $team->users()->detach($memberId);

        $team->users;
        $team->invitations;
        $team['upcomingHappenings'] = $team->happenings()->where('start', '>', new \DateTime())->get();

        return response($team, 200);
    }

    public function leaveTeam(Request $request, $id)
    {
        $team = Team::find($id);
        if (null === $team) {
            return response([
                "message" => "Groupe inconnu"
            ], 404);
        }

        $user = $request->user();
        foreach ($team->users as $elem) {
            if ($elem->id === $user->id && 1 === $elem->pivot->admin) {
                return response([
                    "message" => "Vous ne pouvez quitter un groupe dont vous êtes admin"
                ], 403);
                exit;
            }
        }

        $team->users()->detach($user->id);

        $team->users;
        $team->invitations;
        $team['upcomingHappenings'] = $team->happenings()->where('start', '>', new \DateTime())->get();

        return response([
            "message" => "Groupe quitté"
        ], 200);
    }
}

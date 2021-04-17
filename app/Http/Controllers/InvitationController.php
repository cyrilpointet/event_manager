<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function createFromTeam(Request $request, $id)
    {
        $request->validate([
            'user_email' => 'required',
        ]);

        $test = Invitation::where('team_id', '=', $id)->where('user_email', '=', $request->user_email)->get();
        if (0 !== count($test)) {
            return response([
                "message" => "invitation déjà existante"
            ], 403);
        }

        $user = User::where('email', '=', $request->user_email)->first();
        if (null !== $user) {
            $teams = $user->teams()->where('team_id', '=', $id)->get();
            if (0 !== count($teams)) {
                return response([
                    'message' => ['Déjà membre du groupe']
                ], 403);
            }
        }

        $invitation = Invitation::create([
            'team_id' => $id,
            'user_email' => $request->user_email,
            'is_from_team' => true
        ]);

        return response($invitation, 201);
    }

    public function createFromUser(Request $request)
    {
        $request->validate([
            'team_id' => 'required',
        ]);

        $user = $request->user();
        $teams = $user->teams()->where('team_id', '=', $request->team_id)->get();
        if (0 !== count($teams)) {
            return response([
                'message' => ['Déjà membre du groupe']
            ], 403);
        }

        $test = Invitation::where('team_id', '=', $request->team_id)->where('user_email', '=', $user->email)->get();
        if (0 !== count($test)) {
            return response([
                "message" => "invitation déjà existante"
            ], 403);
        }

        $invitation = Invitation::create([
            'team_id' => $request->team_id,
            'user_email' => $user->email,
            'is_from_team' => false
        ]);

        return response($invitation, 201);
    }

    public function manageTeamInvitation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $invitation = Invitation::find($id);

        if (null === $invitation) {
            return response([
                "message" => "Invitation invalide"
            ], 404);
        }
        $team = Team::find($invitation->team_id);
        if (null === $team) {
            return response([
                "message" => "Groupe inconnu"
            ], 404);
        }

        $user = $request->user();
        if ($user->email !== $invitation->user_email || true !== $invitation->is_from_team) {
            return response([
                "message" => "Validation interdite"
            ], 401);
        }

        if (true === $request->status) {
            $team->users()->attach($user->id, ['admin' => false]);
        }
        $team->users;

        $invitation->delete();
        return $team;
    }

    public function manageUserInvitation(Request $request, $id, $invitationId)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $invitation = Invitation::find($invitationId);

        if (null === $invitation) {
            return response([
                "message" => "Invitation invalide"
            ], 404);
        }
        if (intval($id) !== $invitation->team_id) {
            return response([
                "message" => "Invitation non conforme au groupe"
            ], 401);
        }
        if (false !== $invitation->is_from_team) {
            return response([
                "message" => "Validation interdite"
            ], 401);
        }

        $team = Team::find($id);
        if (null === $team) {
            return response([
                "message" => "Groupe inconnu"
            ], 404);
        }

        $user = User::firstWhere('email', $invitation->user_email);
        if (null === $user) {
            return response([
                "message" => "Utilisateur inconnu"
            ], 404);
        }

        if (true === $request->status) {
            $team->users()->attach($user->id, ['admin' => false]);
        }
        $team->users;

        $invitation->delete();
        return $team;
    }
}

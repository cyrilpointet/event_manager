<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $testExist = User::where('email', $request->email)->first();
        if ($testExist) {
            return response([
                'message' => ['Already used email']
            ], 404);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('event_manager')->plainTextToken;
        $user->teams;
        $user->invitations;
        $user['upcomingHappenings'] = [];

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Ces identifiant ne correspondent pas']
            ], 404);
        }

        $token = $user->createToken('event_manager')->plainTextToken;
        $user->teams;
        $user->invitations;
        $user['upcomingHappenings'] = $user->happenings()->where('start_at', '>', new \DateTime())->get();
        foreach ($user['upcomingHappenings'] as $happening) {
            $happening->team;
        }

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $user->teams;
        $user->invitations;
        $user['upcomingHappenings'] = $user->happenings()->where('start_at', '>', new \DateTime())->get();
        foreach ($user['upcomingHappenings'] as $happening) {
            $happening->team;
        }
        return $user;
    }

    public function getUserByNameOrEmail($name)
    {
        return User::where('name', 'like', '%' . $name . '%')->orWhere('email', 'like', '%' . $name . '%')->take(10)->get();
    }
}

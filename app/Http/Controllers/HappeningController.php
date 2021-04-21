<?php

namespace App\Http\Controllers;

use App\Models\Happening;
use Illuminate\Http\Request;

class HappeningController extends Controller
{
    public function create(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'place' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $happening = Happening::create([
            'name' => $request->name,
            'description' => $request->description,
            'place' => $request->place,
            'team_id' => $id,
            'start' => new \DateTime($request->start),
            'end' => new \DateTime($request->end),
        ]);

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

        return response($happening, 200);
    }
}

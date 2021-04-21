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
            'start_at' => 'required',
            'end_at' => 'required',
        ]);

        $happening = Happening::create([
            'name' => $request->name,
            'description' => $request->description,
            'place' => $request->place,
            'team_id' => $id,
            'start_at' => new \DateTime($request->start_at),
            'end_at' => new \DateTime($request->end_at),
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'place' => 'required',
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
        $happening->description = $request->description;
        $happening->place = $request->place;
        $happening->start_at = new \DateTime($request->start_at);
        $happening->end_at = new \DateTime($request->end_at);

        $happening->save();
        $happening->team;

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
}

<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::truncate();
        $team = Team::create([
            'name' => 'testGroupNoToto'
        ]);
        $team->users()->attach(1);
        $team->users()->attach(2);
        $team->save();
    }
}

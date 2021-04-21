<?php

namespace Database\Seeders;

use App\Models\Happening;
use Illuminate\Database\Seeder;

class HappeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Happening::truncate();
        $start = new \DateTime('2021-04-10 11:21:50');
        $end = new \DateTime('2021-04-10 12:21:50');
        Happening::create([
            'name' => 'test event 1',
            'description' => 'description test',
            'place' => 'place test',
            'team_id' => 1,
            'start' => $start,
            'end' => $end
        ]);

        $start = new \DateTime('2021-04-25 11:21:50');
        $end = new \DateTime('2021-04-25 12:21:50');
        Happening::create([
            'name' => 'test event 2',
            'description' => 'description test',
            'place' => 'place test',
            'team_id' => 1,
            'start' => $start,
            'end' => $end
        ]);

        $start = new \DateTime('2021-04-30 11:21:50');
        $end = new \DateTime('2021-04-30 12:21:50');
        Happening::create([
            'name' => 'test event group 2',
            'description' => 'description test',
            'place' => 'place test',
            'team_id' => 2,
            'start' => $start,
            'end' => $end
        ]);
    }
}

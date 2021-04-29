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
        $start = new \DateTime('2021-11-10 11:21:50');
        $end = new \DateTime('2021-11-10 12:21:50');
        $test1 = Happening::create([
            'name' => 'test event 1',
            'status_id' => 1,
            'description' => 'description test',
            'place' => 'place test',
            'team_id' => 1,
            'start_at' => $start,
            'end_at' => $end
        ]);
        $test1->users()->attach(1);
        $test1->users()->attach(2);

        $start = new \DateTime('2021-04-25 11:21:50');
        $end = new \DateTime('2021-04-25 12:21:50');
        $test2 = Happening::create([
            'name' => 'test event 2',
            'status_id' => 1,
            'description' => 'description test',
            'place' => 'place test',
            'team_id' => 1,
            'start_at' => $start,
            'end_at' => $end
        ]);
        $test2->users()->attach(1);
        $test2->users()->attach(2);

        $start = new \DateTime('2021-11-30 11:21:50');
        $end = new \DateTime('2021-11-30 12:21:50');
        $test3 = Happening::create([
            'name' => 'test event group 2',
            'status_id' => 1,
            'description' => 'description test',
            'place' => 'place test',
            'team_id' => 2,
            'start_at' => $start,
            'end_at' => $end
        ]);
        $test3->users()->attach(2);
    }
}

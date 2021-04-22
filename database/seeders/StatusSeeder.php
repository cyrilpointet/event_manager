<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::truncate();
        Status::create([
            'name' => 'project'
        ]);
        Status::create([
            'name' => 'validated'
        ]);
        Status::create([
            'name' => 'cancelled'
        ]);
    }
}

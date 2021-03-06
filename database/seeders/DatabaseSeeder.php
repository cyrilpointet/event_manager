<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('teams_users')->truncate();
        DB::table('happening_user')->truncate();
        $this->call(StatusSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(InvitationSeeder::class);
        $this->call(HappeningSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}

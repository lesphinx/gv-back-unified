<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersGenerate::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ReservationVoyageSeeder::class);
        $this->call(ReservationLocationSeeder::class);
       //$this->call(ArticleSeeder::class);

    }
}

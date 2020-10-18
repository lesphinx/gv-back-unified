<?php

use Illuminate\Database\Seeder;
use App\ReservationLocation;

class ReservationLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 100;
        factory('App\ReservationLocation', $count)->create();
    }
}

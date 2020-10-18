<?php

use Illuminate\Database\Seeder;

use App\ReservationVoyage;

class ReservationVoyageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 100;
        factory('App\ReservationVoyage', $count)->create();
    }
}

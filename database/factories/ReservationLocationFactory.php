<?php

use Faker\Generator as Faker;

$factory->define(App\ReservationLocation::class, function (Faker $faker) {
    return [
        'date_reservation' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'date_validation' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'date_debut' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'date_fin' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'prix_location' => $faker->buildingNumber(),
        'statut' => '2',
        'commentaire' => $faker->buildingNumber(),
        'slug' => str_randomize(10),
        'note'=> $faker->buildingNumber(),
        'location' => 1,
        'client' => 1,
       
    ];
});

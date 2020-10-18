<?php

use Faker\Generator as Faker;

$factory->define(App\ReservationVoyage::class, function (Faker $faker) {
    return [
        
                'date_reservation' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
                'date_validation' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
                'dateVoyage' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
                'prix_voyage' => $faker->buildingNumber(),
                'statut' => '1',
                'nom_voyageur' => $faker->name(),
                'prenom_voyageur' => $faker->name(),
                'slug' => str_randomize(10),
                'age_voyageur'=>$faker->randomDigit(),
                'numero_piece' => $faker->isbn10(),
                'type_piece' => $faker->randomDigit(),
                'billet' => 1,
                'client' => 1,
                'classe' => 1,
                'voyage' => 1,

    ];
});

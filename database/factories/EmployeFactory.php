<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employe;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Employe::class, function (Faker $faker) {
    return [
        'uuid' => Str::slug( (string) Str::orderedUuid() ),
        'nom' => $faker->lastName,
        'matricule' => Str::random(10),
        'prenom' =>$faker->firstName,
        'adresse' => $faker->address,
        'status_id' => 1,
    ];
});

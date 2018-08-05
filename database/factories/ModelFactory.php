<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
//    return [
//        'name'           => $faker->name,
//        'email'          => $faker->safeEmail,
//        'password'       => bcrypt(str_random(10)),
//        'remember_token' => str_random(10),
//    ];
//});
//
//$factory->define(App\Models\Roles::class, function (Faker\Generator $faker) {
//    return [
//        'name' => $faker->name,
//        'prms' => str_random(),
//    ];
//});


$factory->define(App\Articles::class, function (Faker\Generator $faker) {
    return [
        'title'=>$faker->sentence
    ];
});

$factory->define(\App\Models\Member\Member::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->name,
        'password'=>$faker->password(),
        'email'=>$faker->email
    ];
});

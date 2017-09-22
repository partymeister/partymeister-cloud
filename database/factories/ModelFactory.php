<?php

require_once(__DIR__.'/../../packages/dfox288/motor-backend/database/factories/ModelFactory.php');

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

$factory->define(App\Models\Project::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->word,
        'api_token'  => str_random(60),
        'subdomain'  => $faker->url,
        'client_id'  => factory(Motor\Backend\Models\Client::class)->create()->id,
        'created_by' => factory(Motor\Backend\Models\User::class)->create()->id,
        'updated_by' => factory(Motor\Backend\Models\User::class)->create()->id,
    ];
});

$factory->define(App\Models\App::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->word,
        'client_id'  => factory(Motor\Backend\Models\Client::class)->create()->id,
        'project_id' => factory(App\Models\Project::class)->create()->id,
        'created_by' => factory(Motor\Backend\Models\User::class)->create()->id,
        'updated_by' => factory(Motor\Backend\Models\User::class)->create()->id,
    ];
});

$factory->define(App\Models\Website::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->word,
        'client_id'  => factory(Motor\Backend\Models\Client::class)->create()->id,
        'project_id' => factory(App\Models\Project::class)->create()->id,
        'created_by' => factory(Motor\Backend\Models\User::class)->create()->id,
        'updated_by' => factory(Motor\Backend\Models\User::class)->create()->id,
    ];
});

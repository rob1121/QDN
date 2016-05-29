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

$factory->define(App\User::class, function () {
    return [
        'employee_id' => factory(App\Employee::class)->create()->user_id,
        'password' => Hash::make('fakepassword'),
        'access_level' => 'user',
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Models\CauseOfDefect::class, function (Faker\Generator $faker) {
    return [
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
        'cause_of_defect' =>  $faker->word ,
        'cause_of_defect_description' =>  $faker->word ,
        'objective_evidence' =>  $faker->word ,
    ];
});

$factory->define(App\Models\Closure::class, function (Faker\Generator $faker) {
    return [
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
        'containment_action_taken' =>  $faker->word ,
        'corrective_action_taken' =>  $faker->word ,
        'verified_by' =>  $faker->word ,
        'close_by' =>  $faker->word ,
        'date_sign' =>  $faker->word ,
        'production' =>  $faker->word ,
        'process_engineering' =>  $faker->word ,
        'quality_assurance' =>  $faker->word ,
        'other_department' =>  $faker->word ,
        'pe_verified_by' =>  $faker->word ,
        'status' =>  $faker->word ,
    ];
});

$factory->define(App\Models\ContainmentAction::class, function (Faker\Generator $faker) {
    return [
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
        'what' =>  $faker->word ,
        'who' =>  $faker->word ,
        'objective_evidence' =>  $faker->word ,
    ];
});

$factory->define(App\Models\CorrectiveAction::class, function (Faker\Generator $faker) {
    return [
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
        'what' =>  $faker->word ,
        'who' =>  $faker->word ,
        'objective_evidence' =>  $faker->word ,
    ];
});

$factory->define(App\Models\EventLogs::class, function (Faker\Generator $faker) {
    return [
        'user_id' =>  $faker->word ,
        'name' =>  $faker->name ,
        'action' =>  $faker->word ,
        'comment' =>  $faker->word ,
        'ip' =>  $faker->word ,
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
    ];
});

$factory->define(App\Models\Info::class, function (Faker\Generator $faker) {
    return [
        'control_id' =>  $faker->word ,
        'customer' =>  $faker->word ,
        'package_type' =>  $faker->word ,
        'device_name' =>  $faker->word ,
        'lot_id_number' =>  $faker->word ,
        'lot_quantity' =>  $faker->word ,
        'job_order_number' =>  $faker->word ,
        'machine' =>  $faker->word ,
        'station' =>  $faker->word ,
        'major' =>  $faker->word ,
        'disposition' =>  $faker->word ,
        'problem_description' =>  $faker->word ,
        'failure_mode' =>  $faker->word ,
        'discrepancy_category' =>  $faker->word ,
        'quantity' =>  $faker->word ,
        'slug' =>  $faker->word ,
    ];
});

$factory->define(App\Models\InvolvePerson::class, function (Faker\Generator $faker) {
    return [
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
        'department' =>  $faker->word ,
        'originator_id' =>  $faker->word ,
        'originator_name' =>  $faker->word ,
        'receiver_id' =>  $faker->word ,
        'receiver_name' =>  $faker->word ,
    ];
});

$factory->define(App\Models\PreventiveAction::class, function (Faker\Generator $faker) {
    return [
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
        'what' =>  $faker->word ,
        'who' =>  $faker->word ,
        'objective_evidence' =>  $faker->word ,
    ];
});

$factory->define(App\Models\QdnCycle::class, function (Faker\Generator $faker) {
    return [
        'info_id' =>  function () {
             return factory(App\Models\Info::class)->create()->id;
        } ,
        'cycle_time' =>  $faker->word ,
        'production_cycle_time' =>  $faker->word ,
        'process_engineering_cycle_time' =>  $faker->word ,
        'quality_assurance_cycle_time' =>  $faker->word ,
        'other_department_cycle_time' =>  $faker->word ,
    ];
});

$factory->define(App\Account::class, function (Faker\Generator $faker) {
    return [
        'employee_id' =>  function () {
             return factory(App\Employee::class)->create()->id;
        } ,
    ];
});

$factory->define(App\Employee::class, function (Faker\Generator $faker) {
    return [
        'user_id' =>  $faker->unique()->randomNumber() ,
        'name' =>  $faker->name ,
        'station' =>  $faker->word ,
        'department' =>  $faker->word ,
        'position' =>  $faker->word ,
        'remember_token' =>  str_random(10) ,
        'email' =>  $faker->safeEmail ,
        'status' =>  $faker->word ,
    ];
});

$factory->define(App\OptionModels\Discrepancy::class, function (Faker\Generator $faker) {
    return [
        'name' =>  $faker->name ,
        'category' =>  $faker->word ,
        'is_major' =>  $faker->word ,
    ];
});

$factory->define(App\OptionModels\Machine::class, function (Faker\Generator $faker) {
    return [
        'name' =>  $faker->name ,
    ];
});

$factory->define(App\OptionModels\Option::class, function (Faker\Generator $faker) {
    return [
        'customer' =>  $faker->word ,
    ];
});

$factory->define(App\OptionModels\Station::class, function (Faker\Generator $faker) {
    return [
        'station' =>  $faker->word ,
        'department' =>  $faker->word ,
    ];
});

$factory->define(App\Question::class, function (Faker\Generator $faker) {
    return [
        'user_id' =>  $faker->randomNumber() ,
        'question' =>  $faker->word ,
        'answer' =>  $faker->word ,
        'info_id' =>  function () {
             return factory(App\Employee::class)->create()->id;
        } ,
    ];
});


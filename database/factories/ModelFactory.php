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

$factory->define(Modules\Admin\ProductGroup::class, function (Faker\Generator $faker) {
    return [
        'group_name' => $faker->name,
        'status' =>'active',
        'created_by' =>'1',
        'created_at' =>'1',
        'updated_by' =>'1',
        'updated_at' =>'1',

    ];
});

$factory->define(Modules\Admin\Company::class, function (Faker\Generator $faker) {
    return [
        'company_name' => $faker->name,
        'company_type' =>'client_company',
        'company_group_id' =>'1',
        'industry_id' =>'1',
        'business_type_id' =>'1',
        'factory_address' =>$faker->address,
        'ho_address' =>$faker->address,
        'email' =>$faker->email,
        'phone' =>$faker->phoneNumber,
        'mobile' =>$faker->phoneNumber,
        'created_by' =>'1',
        'created_at' =>'1',
        'updated_by' =>'1',
        'updated_at' =>'1',

    ];
});
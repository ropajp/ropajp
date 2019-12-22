<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model\Shop;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token' => Str::random(10),
        'phone_number' => '09000000000',
        'postcode' => '12345678',
        'state' => '東京',
        'city' => '新宿',
        'town_street' => '新宿ビル5-23-4',
        'category' => 'カジュアル',
        'gender_for' => '男性',
        'shop_detail' => 'カジュアルなお店です。' ,
        'created_at' => now(),
        'updated_at' => now(),
        'deleted_at' => now(),
    ];
});

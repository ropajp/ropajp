<?php

use Illuminate\Database\Seeder;
use App\Models\Shop;
use Faker\Factory as Faker;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::truncate();

        $faker = Faker::create('ja_JP');

        for($i = 0; $i < 10; $i++){
           User::create([
               'name' => $faker->name,
               'email' => $faker->email,
               'password' => Hash::make('testtest')
               'phone_number' => $faker->
           ]);
    }
}

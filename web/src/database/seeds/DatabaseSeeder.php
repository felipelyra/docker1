<?php

use App\Brand;
use App\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $faker = \Faker\Factory::create();
        

        for ($i = 0; $i < 5; $i++) {
            Brand::create([
                'brand' => $faker->colorName,
            ]);
        }

        for ($i = 0; $i < 1000; $i++) {
            Product::create([
                'title' => $faker->firstName,
                'brand_id' => $faker->randomFloat(0, 1, 5),
                'price' => $faker->randomFloat(2, 1, 200),
                'stock' => $faker->randomDigitNotNull,
            ]);
        }

    }
}

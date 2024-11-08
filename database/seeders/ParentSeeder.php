<?php

namespace Database\Seeders;

use App\Models\MyParent;
use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ParentSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['parents']);

        $faker = Faker::create();
        $fakerAr = Faker::create('ar_EG'); // Arabic locale

        for ($i = 0; $i < 100; $i++) {
            MyParent::create([
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('123456789'),
                'father_name' => ['en' => $faker -> name, 'ar' => $fakerAr -> name],
                'father_job' => ['en' => $faker -> jobTitle, 'ar' => $fakerAr -> jobTitle],
                'father_national_id' => $faker->numerify('##########'),
                'father_passport_id' => $faker->numerify('##########'),
                'father_phone' => $faker->numerify('###########'),
                'father_nationality' => rand(1, 245),
                'father_blood_type' => rand(1, 8),
                'father_religion' => rand(1, 3),
                'father_address' => ['en' => $faker -> address, 'ar' => $fakerAr -> address],

                'mother_name' => ['en' => $faker -> name, 'ar' => $fakerAr -> name],
                'mother_job' => ['en' => $faker -> jobTitle, 'ar' => $fakerAr -> jobTitle],
                'mother_national_id' => $faker->numerify('##########'),
                'mother_passport_id' => $faker->numerify('##########'),
                'mother_phone' => $faker->numerify('###########'),
                'mother_nationality' => rand(1, 245),
                'mother_blood_type' => rand(1, 8),
                'mother_religion' => rand(1, 3),
                'mother_address' => ['en' => $faker -> address, 'ar' => $fakerAr -> address],
            ]);
        }
    }
}

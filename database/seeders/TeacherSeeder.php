<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['teachers']);

        $faker = Faker::create();
        $fakerAr = Faker::create('ar_EG');

        for ($i = 0; $i < 75; $i++) {
            Teacher::create([
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('123456789'),
                'name' => ['en' => $faker -> name, 'ar' => $fakerAr -> name],
                'subject_id' => rand(1, 21),
                'gender_id' => rand(1, 2),
                'joining_date' => $faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
                'address' => $faker -> address,
            ]);
        }

    }
}

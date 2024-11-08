<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['genders']);

        $genders = [
            ['en' => 'Male', 'ar' => 'ذكر'],
            ['en' => 'Female', 'ar' => 'انثي'],

        ];

        foreach ($genders as $ge) {
            Gender::create(['name' => $ge]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Stage;

class StageSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['stages']);

        $stages = [
            ['en' => 'Kindergarten ', 'ar' => 'رياض الأطفال'],
            ['en' => 'Elementary Stage', 'ar' => 'المرحلة الابتدائية'],
            ['en' => 'Middle School', 'ar' => 'المرحلة الإعدادية'],
            ['en' => 'High School', 'ar' => 'المرحلة الثانوية'],
        ];

        foreach ($stages as $stage) {
            Stage::create(['name' => $stage]);
        }
    }
}

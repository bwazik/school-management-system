<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['settings']);

        Setting::create([
            'school_title' => 'My School System',
            'school_name' => ['en' => 'My School' , 'ar' => 'مدرستي',],
            'school_address' => ['en' => '123 School St., City, Country' , 'ar' => '123 شارع المدرسة، المدينة، الدولة',],
            'school_phone' => '0123456789',
            'school_email' => 'info@myschool.com',
            'school_logo' => 'logo.png',
            'default_language' => 'ar',
            'timezone' => 'Africa/Cairo',
            'academic_year_start' => '2024-09-01',
            'academic_year_end' => '2025-06-30',
            'max_students_per_class' => 30,
        ]);
    }
}

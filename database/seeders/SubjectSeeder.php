<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['subjects']);

        $subjects = [
            ['en' => 'Mathematics', 'ar' => 'الرياضيات'],
            ['en' => 'Science', 'ar' => 'العلوم'],
            ['en' => 'Computer Science', 'ar' => 'علوم الحاسوب'],
            ['en' => 'Arabic', 'ar' => 'اللغة العربية'],
            ['en' => 'English', 'ar' => 'اللغة الإنجليزية'],
            ['en' => 'German', 'ar' => 'الألمانية'],
            ['en' => 'French', 'ar' => 'الفرنسية'],
            ['en' => 'Spanish', 'ar' => 'الإسبانية'],
            ['en' => 'History', 'ar' => 'التاريخ'],
            ['en' => 'Geography', 'ar' => 'الجغرافيا'],
            ['en' => 'Physical Education', 'ar' => 'التربية البدنية'],
            ['en' => 'Art', 'ar' => 'الفنون'],
            ['en' => 'Biology', 'ar' => 'الأحياء'],
            ['en' => 'Chemistry', 'ar' => 'الكيمياء'],
            ['en' => 'Physics', 'ar' => 'الفيزياء'],
            ['en' => 'Social Studies', 'ar' => 'الدراسات الاجتماعية'],
            ['en' => 'Economics', 'ar' => 'الاقتصاد'],
            ['en' => 'Health Education', 'ar' => 'التربية الصحية'],
            ['en' => 'Information Technology', 'ar' => 'تكنولوجيا المعلومات'],
            ['en' => 'Music', 'ar' => 'الموسيقى'],
            ['en' => 'Drama', 'ar' => 'الدراما'],
        ];

        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}

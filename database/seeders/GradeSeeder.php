<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['grades']);

        $Kindergarten_grades = [
            ['en' => 'Kindergarten 1', 'ar' => 'رياض الأطفال 1'],
            ['en' => 'Kindergarten 1', 'ar' => 'رياض الأطفال 2'],
        ];

        foreach ($Kindergarten_grades as $Kindergarten_grade) {
            Grade::create([
                'name' => $Kindergarten_grade,
                'stage_id' => 1,
            ]);
        }

        $elementary_grades = [
            ['en' => 'Grade 1', 'ar' => 'الصف الدراسي الأول'],
            ['en' => 'Grade 2', 'ar' => 'الصف الدراسي الثاني'],
            ['en' => 'Grade 3', 'ar' => 'الصف الدراسي الثالث'],
            ['en' => 'Grade 4', 'ar' => 'الصف الدراسي الرابع'],
            ['en' => 'Grade 5', 'ar' => 'الصف الدراسي الخامس'],
            ['en' => 'Grade 6', 'ar' => 'الصف الدراسي السادس'],
        ];

        foreach ($elementary_grades as $elementary_grade) {
            Grade::create([
                'name' => $elementary_grade,
                'stage_id' => 2,
            ]);
        }

        $middleschool_grades = [
            ['en' => 'Grade 7', 'ar' => 'الصف الدراسي الأول'],
            ['en' => 'Grade 8', 'ar' => 'الصف الدراسي الثاني'],
            ['en' => 'Grade 9', 'ar' => 'الصف الدراسي الثالث'],
        ];

        foreach ($middleschool_grades as $middleschool_grade) {
            Grade::create([
                'name' => $middleschool_grade,
                'stage_id' => 3,
            ]);
        }

        $highschool_grades = [
            ['en' => 'Grade 10', 'ar' => 'الصف الدراسي الأول'],
            ['en' => 'Grade 11', 'ar' => 'الصف الدراسي الثاني'],
            ['en' => 'Grade 12', 'ar' => 'الصف الدراسي الثالث'],
        ];

        foreach ($highschool_grades as $highschool_grade) {
            Grade::create([
                'name' => $highschool_grade,
                'stage_id' => 4,
            ]);
        }
    }
}

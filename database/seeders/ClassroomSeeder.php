<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Traits\Truncatable;

class ClassroomSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['classrooms']);

        $classrooms = [];
        $grades = [
            1 => ['en' => 'Kindergarten 1', 'ar' => 'رياض الأطفال 1', 'stage_id' => 1],
            2 => ['en' => 'Kindergarten 2', 'ar' => 'رياض الأطفال 2', 'stage_id' => 1],
            3 => ['en' => 'Grade 1', 'ar' => 'الصف الدراسي الأول', 'stage_id' => 2],
            4 => ['en' => 'Grade 2', 'ar' => 'الصف الدراسي الثاني', 'stage_id' => 2],
            5 => ['en' => 'Grade 3', 'ar' => 'الصف الدراسي الثالث ', 'stage_id' => 2],
            6 => ['en' => 'Grade 4', 'ar' => 'الصف الدراسي الرابع', 'stage_id' => 2],
            7 => ['en' => 'Grade 5', 'ar' => 'الصف الدراسي الخامس', 'stage_id' => 2],
            8 => ['en' => 'Grade 6', 'ar' => 'الصف الدراسي السادس', 'stage_id' => 2],
            9 => ['en' => 'Grade 7', 'ar' => 'الصف الدراسي الأول', 'stage_id' => 3],
            10 => ['en' => 'Grade 8', 'ar' => 'الصف الدراسي الثاني', 'stage_id' => 3],
            11 => ['en' => 'Grade 9', 'ar' => 'الصف الدراسي الثالث', 'stage_id' => 3],
            12 => ['en' => 'Grade 10', 'ar' => 'الصف الدراسي الأول', 'stage_id' => 4],
            13 => ['en' => 'Grade 11', 'ar' => 'الصف الدراسي الثاني', 'stage_id' => 4],
            14 => ['en' => 'Grade 12', 'ar' => 'الصف الدراسي الثالث', 'stage_id' => 4],
        ];

        $classroom_counts = [
            1 => 3,
            2 => 3,
            3 => 5,
            4 => 5,
            5 => 5,
            6 => 5,
            7 => 5,
            8 => 5,
            9 => 4,
            10 => 4,
            11 => 4,
            12 => 4,
            13 => 4,
            14 => 4,
        ];

        foreach ($grades as $grade_id => $grade) {
            for ($i = 1; $i <= $classroom_counts[$grade_id]; $i++) {
                Classroom::create([
                    'name' => ['en' => 'Classroom ' . chr(64 + $i), 'ar' => 'الفصل ' . chr(64 + $i)],
                    'stage_id' => $grade['stage_id'],
                    'grade_id' => $grade_id,
                    'status' => rand(0,1),
                ]);
            }
        }
    }
}

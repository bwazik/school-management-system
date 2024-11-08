<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Traits\Truncatable;

class ClassroomTeacherSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['classroom_teacher']);

        $classrooms = Classroom::select('id')->get();
        $teacherIds = Teacher::pluck('id')->toArray();

        foreach ($classrooms as $classroom) {
            $randomTeacherIds = array_rand(array_flip($teacherIds), rand(1, 5));
            $classroom->teachers()->attach($randomTeacherIds);
        }
    }
}

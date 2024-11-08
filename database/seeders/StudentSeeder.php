<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['students']);

        $faker = Faker::create();
        $fakerAr = Faker::create('ar_EG'); // Arabic locale

        for ($i = 0; $i < 150; $i++) {

            $stage_id = rand(1, 4);
            $grade_id = $this -> getGradeIdBasedOnStage($stage_id);
            $classroom_id = $this->getClassroomIdBasedOnGrade($grade_id);

            Student::create([
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('123456789'),
                'name' => ['en' => $faker -> name, 'ar' => $fakerAr -> name],
                'stage_id' => $stage_id,
                'grade_id' => $grade_id,
                'classroom_id' => $classroom_id,
                'parent_id' => rand(1, 100),
                'academic_year' => rand(now()->year, now()->year + 1),
                'gender_id' => rand(1, 2),
                'nationality' => rand(1, 245),
                'blood_type' => rand(1, 8),
                'religion' => rand(1, 3),
                'birthday' => now()->subYears(rand(10, 20))->toDateString(),
            ]);
        }

    }

    private function getGradeIdBasedOnStage($stage_id)
    {
        switch ($stage_id) {
            case 1:
                return rand(1, 2);
            case 2:
                return rand(3, 8);
            case 3:
                return rand(9, 11);
            case 4:
                return rand(12, 14);
            default:
                return 1;
        }
    }

    private function getClassroomIdBasedOnGrade($grade_id)
    {
        switch ($grade_id) {
            case 1:
                return rand(1, 3);
            case 2:
                return rand(4, 6);
            case 3:
                return rand(7, 11);
            case 4:
                return rand(12, 16);
            case 5:
                return rand(17, 21);
            case 6:
                return rand(22, 26);
            case 7:
                return rand(27, 31);
            case 8:
                return rand(32, 36);
            case 9:
                return rand(37, 40);
            case 10:
                return rand(41, 44);
            case 11:
                return rand(45, 48);
            case 12:
                return rand(49, 52);
            case 13:
                return rand(53, 56);
            case 14:
                return rand(57, 60);
            default:
                return 1;
        }
    }
}

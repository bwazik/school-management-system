<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(StageSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(ClassroomSeeder::class);
        $this->call(BloodSeeder::class);
        $this->call(ReligionSeeder::class);
        $this->call(NationalitySeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(ParentSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(ClassroomTeacherSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(FeeSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(QuizSeeder::class);
        $this->call(SettingSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Fee;
use Faker\Factory as Faker;

class FeeSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['fees']);
        $faker = Faker::create();
        $fees = [
            ['en' => 'Tuition Fee', 'ar' => 'الرسوم الدراسية'],
            ['en' => 'Library Fee', 'ar' => 'رسوم المكتبة'],
            ['en' => 'Sports Fee', 'ar' => 'رسوم الرياضة'],
            ['en' => 'Graduation Fee', 'ar' => 'رسوم التخرج'],
            ['en' => 'Transport Fee', 'ar' => 'رسوم النقل'],
            ['en' => 'Health Insurance Fee', 'ar' => 'رسوم التأمين الصحي'],
            ['en' => 'Uniform Fee', 'ar' => 'رسوم الزي المدرسي'],
            ['en' => 'Field Trip Fee', 'ar' => 'رسوم الرحلة المدرسية'],
            ['en' => 'Art Supplies Fee', 'ar' => 'رسوم مستلزمات الفنون'],
            ['en' => 'Technology Fee', 'ar' => 'رسوم التكنولوجيا'],
        ];

        foreach (range(1, 4) as $stage_id) {
            foreach ($this->getGradesForStage($stage_id) as $grade_id) {
                foreach ($fees as $fee) {
                    Fee::create([
                        'name' => $fee,
                        'amount' => $faker->randomFloat(2, 1000, 10000),
                        'stage_id' => $stage_id,
                        'grade_id' => $grade_id,
                        'year' => rand(now()->year, now()->year + 1),
                    ]);
                }
            }
        }
    }

    private function getGradesForStage($stage_id)
    {
        switch ($stage_id) {
            case 1:
                return range(1, 2);
            case 2:
                return range(3, 8);
            case 3:
                return range(9, 11);
            case 4:
                return range(12, 14);
            default:
                return [];
        }
    }
}

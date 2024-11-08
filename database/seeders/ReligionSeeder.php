<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['religions']);

        $religions = [
            ['en' => 'Muslim', 'ar' => 'مسلم'],
            ['en' => 'Christian', 'ar' => 'مسيحي'],
            ['en' => 'Other', 'ar' => 'غيرذلك'],
        ];

        foreach ($religions as $religion) {
            Religion::create(['name' => $religion]);
        }
    }
}

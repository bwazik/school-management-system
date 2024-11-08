<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Blood;

class BloodSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['blood_type']);

        $bloodTypes = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];

        foreach ($bloodTypes as $type) {
            Blood::create(['name' => $type]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use Truncatable;

    public function run(): void
    {
        $this->truncateTables(['users']);

        User::create([
            'name' => ['en' => 'Abdullah Mohamed', 'ar' => 'عبدالله محمد'],
            'email' => 'bwazik@outlook.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}

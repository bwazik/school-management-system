<?php

namespace Database\Seeders;

use App\Models\Fee;
use Illuminate\Database\Seeder;
use App\Traits\Truncatable;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\StudentAccount;
use Faker\Factory as Faker;

class InvoiceSeeder extends Seeder
{
    use Truncatable;

    public function run()
    {
        $this->truncateTables(['invoices', 'student_account']);
        $faker = Faker::create();

        for ($i = 0; $i < 500; $i++) {
            $stage_id = rand(1, 4);
            $grade_id = rand(1, 14);
            $student = Student::where('stage_id', $stage_id)
                ->where('grade_id', $grade_id)
                ->inRandomOrder()
                ->first();

            if (!$student) {
                continue;
            }

            $fee = Fee::where('stage_id', $stage_id)
                ->where('grade_id', $grade_id)
                ->inRandomOrder()
                ->first();

            if (!$fee) {
                continue;
            }

            $year = $fee->year;
            $date = $faker->dateTimeBetween("$year-01-01", "$year-12-31")->format('Y-m-d');

            $invoice = Invoice::create([
                'date' => $date,
                'stage_id' => $stage_id,
                'grade_id' => $grade_id,
                'student_id' => $student -> id,
                'fee_id' => $fee -> id,
                'amount' => $fee -> amount,
            ]);

            StudentAccount::create([
                'type' => 1,  // 1 = invoice
                'invoice_id' => $invoice -> id,
                'student_id' => $student -> id,
                'debit' => $invoice -> amount,
                'credit' => 0.00,
            ]);
        }
    }
}

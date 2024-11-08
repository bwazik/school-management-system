<?php

namespace App\Interfaces\Finance;

interface PaymentRepositoryInterface
{
    public function getAllPayments($request);

    public function addStudentPayment($request);

    public function addPayment($request);

    public function editPayment($request);

    public function deletePayment($request);
}

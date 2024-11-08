<?php

namespace App\Interfaces\Finance;

interface ReceiptRepositoryInterface
{
    public function getAllReceipts($request);

    public function addStudentReceipt($request);

    public function addReceipt($request);
    
    public function editReceipt($request);

    public function deleteReceipt($request);
}

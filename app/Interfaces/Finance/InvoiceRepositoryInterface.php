<?php

namespace App\Interfaces\Finance;

interface InvoiceRepositoryInterface
{
    public function getAllInvoices($request);

    public function addStudentInvoice($request);
    
    public function getStudentDetails($id);

    public function addInvoice($request);

    public function deleteInvoice($request);
}

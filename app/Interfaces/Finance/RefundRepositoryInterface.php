<?php

namespace App\Interfaces\Finance;

interface RefundRepositoryInterface
{
    public function getAllRefunds($request);

    public function addStudentRefund($request);
    
    public function getStudentBalance($id);

    public function addRefund($request);

    public function editRefund($request);

    public function deleteRefund($request);
}

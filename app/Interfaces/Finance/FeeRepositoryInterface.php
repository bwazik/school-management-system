<?php

namespace App\Interfaces\Finance;

interface FeeRepositoryInterface
{
    public function getAllFees($request);

    public function addFee($request);

    public function editFee($request);

    public function deleteFee($request);

    public function deleteSelectedFees($request);

    public function getFeeAmount($id);
}

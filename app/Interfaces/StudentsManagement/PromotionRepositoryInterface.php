<?php

namespace App\Interfaces\StudentsManagement;

interface PromotionRepositoryInterface
{
    public function getAllPromotions($request);

    public function addPromotion($request);

    public function revertStudent($request);

    public function revertSelectedStudents($request);

    public function graduateStudent($request);

    public function graduateSelectedStudents($request);

}

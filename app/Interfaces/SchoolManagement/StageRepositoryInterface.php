<?php

namespace App\Interfaces\SchoolManagement;

interface StageRepositoryInterface
{
    public function getAllStages($request);

    public function addStage($request);

    public function editStage($request);

    public function deleteStage($request);

    public function deleteSelectedStages($request);
}

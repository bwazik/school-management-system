<?php

namespace App\Interfaces\SchoolManagement;

interface GradeRepositoryInterface
{
    public function getAllGrades($request);

    public function addGrade($request);

    public function editGrade($request);

    public function deleteGrade($request);

    public function deleteSelectedGrades($request);

    public function filterByStage($request);
}

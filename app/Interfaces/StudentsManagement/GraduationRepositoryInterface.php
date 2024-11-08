<?php

namespace App\Interfaces\StudentsManagement;

interface GraduationRepositoryInterface
{
    public function getAllGraduations($request);

    public function addGraduation($request);

    public function returnStudent($request);

    public function returnSelectedStudents($request);

    public function deleteStudent($request);

    public function deleteSelectedStudents($request);
}

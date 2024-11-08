<?php

namespace App\Interfaces\SchoolManagement;

interface SubjectRepositoryInterface
{
    public function getAllSubjects($request);

    public function addSubject($request);

    public function editSubject($request);

    public function deleteSubject($request);

    public function deleteSelectedSubjects($request);
}

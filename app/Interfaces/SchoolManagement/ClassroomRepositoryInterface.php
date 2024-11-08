<?php

namespace App\Interfaces\SchoolManagement;

interface ClassroomRepositoryInterface
{
    public function getStagesWithClassrooms();

    public function getAllClassrooms($request, $stageId);

    public function getGradesByAjax($id);

    public function getClassroomsByAjax($id);
    
    public function getTeachersByAjax($id);

    public function addClassroom($request);

    public function editClassroom($request);

    public function deleteClassroom($request);
}

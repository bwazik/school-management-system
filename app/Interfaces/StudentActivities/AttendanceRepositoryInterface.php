<?php

namespace App\Interfaces\StudentActivities;

interface AttendanceRepositoryInterface
{
    public function getStagesWithClassrooms();

    public function getAllClassrooms($request, $stageId);

    public function getStudentsWithAttendances($request, $classroomId);

    public function addAttendance($request);
}

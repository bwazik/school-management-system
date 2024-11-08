<?php

namespace App\Http\Controllers\StudentActivities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudentActivities\AttendancesRequest;
use App\Interfaces\StudentActivities\AttendanceRepositoryInterface;

class AttendancesController extends Controller
{
    protected $attendance;

    public function __construct(AttendanceRepositoryInterface $attendance)
    {
        $this -> attendance = $attendance;
    }

    public function index()
    {
        return $this -> attendance -> getStagesWithClassrooms();
    }

    public function getAllClassrooms(Request $request, $stageId)
    {
        return $this -> attendance -> getAllClassrooms($request, $stageId);
    }

    public function getStudentsWithAttendances(Request $request, $classroomId)
    {
        return $this -> attendance -> getStudentsWithAttendances($request, $classroomId);
    }

    public function add(AttendancesRequest $request)
    {
        return $this -> attendance -> addAttendance($request);
    }
}

<?php

namespace App\Http\Controllers\SchoolManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SchoolManagement\ClassroomsRequest;
use App\Interfaces\SchoolManagement\ClassroomRepositoryInterface;

class ClassroomsController extends Controller
{
    protected $classroom;

    public function __construct(ClassroomRepositoryInterface $classroom)
    {
        $this -> classroom = $classroom;
    }

    public function index()
    {
        return $this -> classroom -> getStagesWithClassrooms();
    }

    public function getAllClassrooms(Request $request, $stageId)
    {
        return $this -> classroom -> getAllClassrooms($request, $stageId);
    }

    public function getGradesByAjax($id)
    {
        return $this -> classroom -> getGradesByAjax($id);
    }

    public function getClassroomsByAjax($id)
    {
        return $this -> classroom -> getClassroomsByAjax($id);
    }

    public function getTeachersByAjax($id)
    {
        return $this -> classroom -> getTeachersByAjax($id);
    }

    public function add(ClassroomsRequest $request)
    {
        return $this -> classroom -> addClassroom($request);
    }

    public function edit(ClassroomsRequest $request)
    {
        return $this -> classroom -> editClassroom($request);
    }

    public function delete(Request $request)
    {
        return $this -> classroom -> deleteClassroom($request);
    }
}

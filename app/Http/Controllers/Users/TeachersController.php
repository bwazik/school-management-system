<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Users\ParentsRequest;
use App\Http\Requests\Users\TeachersRequest;
use App\Http\Requests\Users\EditTeacherRequest;
use App\Interfaces\Users\TeacherRepositoryInterface;

class TeachersController extends Controller
{
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {
        $this -> teacher = $teacher;
    }

    public function index(Request $request)
    {
        return $this -> teacher -> getAllTeachers($request);
    }

    public function add(TeachersRequest $request)
    {
        return $this -> teacher -> addTeacher($request);
    }

    public function edit(EditTeacherRequest $request)
    {
        return $this -> teacher -> editTeacher($request);
    }

    public function delete(Request $request)
    {
        return $this -> teacher -> deleteTeacher($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> teacher -> deleteSelectedTeachers($request);
    }

    public function teacherDetails($id)
    {
        return $this -> teacher -> teacherDetails($id);
    }

    public function addAttachment(ParentsRequest $request, $teacher_id)
    {
        return $this -> teacher -> addAttachment($request, $teacher_id);
    }

    public function showAttachment($email, $file)
    {
        return $this -> teacher -> showAttachment($email, $file);
    }

    public function downloadAttachment($email, $file)
    {
        return $this -> teacher -> downloadAttachment($email, $file);
    }

    public function deleteAttachment($id, $email, $file)
    {
        return $this -> teacher -> deleteAttachment($id, $email, $file);
    }

    public function deleteAllAttachments($teacher_id)
    {
        return $this -> teacher -> deleteAllTeacherAttachments($teacher_id);
    }
}

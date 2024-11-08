<?php

namespace App\Http\Controllers\StudentsManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Users\ParentsRequest;
use App\Http\Requests\StudentsManagement\StudentsRequest;
use App\Http\Requests\StudentsManagement\EditStudentRequest;
use App\Interfaces\StudentsManagement\StudentRepositoryInterface;

class StudentsController extends Controller
{
    protected $student;

    public function __construct(StudentRepositoryInterface $student)
    {
        $this -> student = $student;
    }

    public function index(Request $request)
    {
        return $this -> student -> getAllStudents($request);
    }

    public function add(StudentsRequest $request)
    {
        return $this -> student -> addStudent($request);
    }

    public function edit(EditStudentRequest $request)
    {
        return $this -> student -> editStudent($request);
    }

    public function delete(Request $request)
    {
        return $this -> student -> deleteStudent($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> student -> deleteSelectedStudents($request);
    }

    public function graduate(Request $request)
    {
        return $this -> student -> graduateStudent($request);
    }

    public function graduateSelected(Request $request)
    {
        return $this -> student -> graduateSelectedStudents($request);
    }

    public function studentDetails($id)
    {
        return $this -> student -> studentDetails($id);
    }

    public function addAttachment(ParentsRequest $request, $student_id)
    {
        return $this -> student -> addAttachment($request, $student_id);
    }

    public function showAttachment($email, $file)
    {
        return $this -> student -> showAttachment($email, $file);
    }

    public function downloadAttachment($email, $file)
    {
        return $this -> student -> downloadAttachment($email, $file);
    }

    public function deleteAttachment($id, $email, $file)
    {
        return $this -> student -> deleteAttachment($id, $email, $file);
    }

    public function deleteAllAttachments($student_id)
    {
        return $this -> student -> deleteAllStudentAttachments($student_id);
    }
}

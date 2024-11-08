<?php

namespace App\Interfaces\StudentsManagement;

interface StudentRepositoryInterface
{
    public function getAllStudents($request);

    public function addStudent($request);

    public function editStudent($request);

    public function deleteStudent($request);

    public function deleteSelectedStudents($request);

    public function graduateStudent($request);

    public function graduateSelectedStudents($request);

    public function studentDetails($id);

    public function addAttachment($request, $student_id);

    public function showAttachment($email, $file);

    public function downloadAttachment($email, $file);

    public function deleteAttachment($id, $email, $file);

    public function deleteAllStudentAttachments($student_id);
}

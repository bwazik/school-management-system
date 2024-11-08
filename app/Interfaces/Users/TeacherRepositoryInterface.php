<?php

namespace App\Interfaces\Users;

interface TeacherRepositoryInterface
{
    public function getAllTeachers($request);

    public function addTeacher($request);

    public function editTeacher($request);

    public function deleteTeacher($request);

    public function deleteSelectedTeachers($request);

    public function teacherDetails($id);

    public function addAttachment($request, $teacher_id);

    public function showAttachment($email, $file);

    public function downloadAttachment($email, $file);

    public function deleteAttachment($id, $email, $file);

    public function deleteAllTeacherAttachments($teacher_id);
}

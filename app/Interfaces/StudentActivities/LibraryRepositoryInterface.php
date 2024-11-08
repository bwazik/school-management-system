<?php

namespace App\Interfaces\StudentActivities;

interface LibraryRepositoryInterface
{
    public function getAllBooks($request);

    public function addBook($request);

    public function showBook($teacher_email, $file_name);

    public function downloadBook($teacher_email, $file_name);

    public function editBook($request);

    public function deleteBook($request);

    public function deleteSelectedBooks($request);
}

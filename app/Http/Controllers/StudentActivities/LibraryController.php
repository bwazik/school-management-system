<?php

namespace App\Http\Controllers\StudentActivities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudentActivities\LibraryRequest;
use App\Http\Requests\StudentActivities\EditLibraryRequest;
use App\Interfaces\StudentActivities\LibraryRepositoryInterface;

class LibraryController extends Controller
{
    protected $book;

    public function __construct(LibraryRepositoryInterface $book)
    {
        $this -> book = $book;
    }

    public function index(Request $request)
    {
        return $this -> book -> getAllBooks($request);
    }

    public function add(LibraryRequest $request)
    {
        return $this -> book -> addBook($request);
    }

    public function show($teacher_email, $file_name)
    {
        return $this -> book -> showBook($teacher_email, $file_name);
    }

    public function download($teacher_email, $file_name)
    {
        return $this -> book -> downloadBook($teacher_email, $file_name);
    }

    public function edit(EditLibraryRequest $request)
    {
        return $this -> book -> editBook($request);
    }

    public function delete(Request $request)
    {
        return $this -> book -> deleteBook($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> book -> deleteSelectedBooks($request);
    }
}

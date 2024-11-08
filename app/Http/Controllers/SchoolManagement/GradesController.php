<?php

namespace App\Http\Controllers\SchoolManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SchoolManagement\GradesRequest;
use App\Interfaces\SchoolManagement\GradeRepositoryInterface;

class GradesController extends Controller
{
    protected $grade;

    public function __construct(GradeRepositoryInterface $grade)
    {
        $this -> grade = $grade;
    }

    public function index(Request $request)
    {
        return $this -> grade -> getAllGrades($request);
    }

    public function add(GradesRequest $request)
    {
        return $this -> grade -> addGrade($request);
    }

    public function edit(GradesRequest $request)
    {
        return $this -> grade -> editGrade($request);
    }

    public function delete(Request $request)
    {
        return $this -> grade -> deleteGrade($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> grade -> deleteSelectedGrades($request);
    }

    public function filter(Request $request)
    {
        return $this -> grade -> filterByStage($request);
    }
}

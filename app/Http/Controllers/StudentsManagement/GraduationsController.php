<?php

namespace App\Http\Controllers\StudentsManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudentsManagement\GraduationsRequest;
use App\Interfaces\StudentsManagement\GraduationRepositoryInterface;

class GraduationsController extends Controller
{
    protected $graduation;

    public function __construct(GraduationRepositoryInterface $graduation)
    {
        $this -> graduation = $graduation;
    }

    public function index(Request $request)
    {
        return $this -> graduation -> getAllGraduations($request);
    }

    public function add(GraduationsRequest $request)
    {
        return $this -> graduation -> addGraduation($request);
    }

    public function return(Request $request)
    {
        return $this -> graduation -> returnStudent($request);
    }

    public function returnSelected(Request $request)
    {
        return $this -> graduation -> returnSelectedStudents($request);
    }

    public function delete(Request $request)
    {
        return $this -> graduation -> deleteStudent($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> graduation -> deleteSelectedStudents($request);
    }
}

<?php

namespace App\Http\Controllers\SchoolManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SchoolManagement\SubjectsRequest;
use App\Interfaces\SchoolManagement\SubjectRepositoryInterface;

class SubjectsController extends Controller
{
    protected $subject;

    public function __construct(SubjectRepositoryInterface $subject)
    {
        $this -> subject = $subject;
    }

    public function index(Request $request)
    {
        return $this -> subject -> getAllSubjects($request);
    }

    public function add(SubjectsRequest $request)
    {
        return $this -> subject -> addSubject($request);
    }

    public function edit(SubjectsRequest $request)
    {
        return $this -> subject -> editSubject($request);
    }

    public function delete(Request $request)
    {
        return $this -> subject -> deleteSubject($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> subject -> deleteSelectedSubjects($request);
    }
}

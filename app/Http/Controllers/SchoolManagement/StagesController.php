<?php

namespace App\Http\Controllers\SchoolManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SchoolManagement\StagesRequest;
use App\Interfaces\SchoolManagement\StageRepositoryInterface;

class StagesController extends Controller
{
    protected $stage;

    public function __construct(StageRepositoryInterface $stage)
    {
        $this -> stage = $stage;
    }

    public function index(Request $request)
    {
        return $this -> stage -> getAllStages($request);
    }

    public function add(StagesRequest $request)
    {
        return $this -> stage -> addStage($request);
    }

    public function edit(StagesRequest $request)
    {
        return $this -> stage -> editStage($request);
    }

    public function delete(Request $request)
    {
        return $this -> stage -> deleteStage($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> stage -> deleteSelectedStages($request);
    }
}

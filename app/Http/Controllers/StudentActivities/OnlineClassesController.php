<?php

namespace App\Http\Controllers\StudentActivities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudentActivities\OnlineClassesRequest;
use App\Interfaces\StudentActivities\OnlineClassRepositoryInterface;

class OnlineClassesController extends Controller
{
    protected $onlineClass;

    public function __construct(OnlineClassRepositoryInterface $onlineClass)
    {
        $this -> onlineClass = $onlineClass;
    }

    public function index(Request $request)
    {
        return $this -> onlineClass -> getAllOnlineClasses($request);
    }

    public function add(OnlineClassesRequest $request)
    {
        return $this -> onlineClass -> addOnlineClass($request);
    }

    public function edit(OnlineClassesRequest $request)
    {
        return $this -> onlineClass -> editOnlineClass($request);
    }

    public function delete(Request $request)
    {
        return $this -> onlineClass -> deleteOnlineClass($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> onlineClass -> deleteSelectedOnlineClasses($request);
    }
}

<?php

namespace App\Http\Controllers\StudentActivities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudentActivities\QuizzesRequest;
use App\Interfaces\StudentActivities\QuizRepositoryInterface;

class QuizzesController extends Controller
{
    protected $quiz;

    public function __construct(QuizRepositoryInterface $quiz)
    {
        $this -> quiz = $quiz;
    }

    public function index(Request $request)
    {
        return $this -> quiz -> getAllQuizzes($request);
    }

    public function add(QuizzesRequest $request)
    {
        return $this -> quiz -> addQuiz($request);
    }

    public function edit(QuizzesRequest $request)
    {
        return $this -> quiz -> editQuiz($request);
    }

    public function delete(Request $request)
    {
        return $this -> quiz -> deleteQuiz($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> quiz -> deleteSelectedQuizzes($request);
    }
}

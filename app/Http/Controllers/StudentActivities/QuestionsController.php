<?php

namespace App\Http\Controllers\StudentActivities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudentActivities\QuestionsRequest;
use App\Http\Requests\StudentActivities\ChangeAnswerRequest;
use App\Interfaces\StudentActivities\QuestionRepositoryInterface;

class QuestionsController extends Controller
{
    protected $question;

    public function __construct(QuestionRepositoryInterface $question)
    {
        $this -> question = $question;
    }

    public function index($quizId)
    {
        return $this -> question -> questionsWithAnswers($quizId);
    }

    public function add(QuestionsRequest $request)
    {
        return $this -> question -> addQuestion($request);
    }

    public function change(ChangeAnswerRequest $request)
    {
        return $this -> question -> changeAnswer($request);
    }

    public function edit(QuestionsRequest $request)
    {
        return $this -> question -> editQuestion($request);
    }

    public function delete(Request $request)
    {
        return $this -> question -> deleteQuestion($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> question -> deleteSelectedQuestions($request);
    }
}

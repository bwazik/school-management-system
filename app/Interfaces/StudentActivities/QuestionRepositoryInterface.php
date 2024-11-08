<?php

namespace App\Interfaces\StudentActivities;

interface QuestionRepositoryInterface
{
    public function questionsWithAnswers($quizId);

    public function addQuestion($request);
    
    public function changeAnswer($request);

    public function editQuestion($request);

    public function deleteQuestion($request);

    public function deleteSelectedQuestions($request);
}

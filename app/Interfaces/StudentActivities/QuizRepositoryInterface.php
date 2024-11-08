<?php

namespace App\Interfaces\StudentActivities;

interface QuizRepositoryInterface
{
    public function getAllQuizzes($request);

    public function addQuiz($request);

    public function editQuiz($request);

    public function deleteQuiz($request);

    public function deleteSelectedQuizzes($request);
}

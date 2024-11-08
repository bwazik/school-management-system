<?php

namespace App\Repositories\StudentActivities;

use App\Interfaces\StudentActivities\QuestionRepositoryInterface;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\DB;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function questionsWithAnswers($quizId)
    {
        $checkQuizId = Quiz::findOrFail($quizId);

        if($checkQuizId)
        {
            $questionsWithAnswers = Question::with(['answers'])->where('quiz_id', $quizId)->select('id', 'question_text', 'degree')->orderBy('id')->get();

            return view('studentactivities.questions.index', compact('questionsWithAnswers', 'quizId'));
        }
        else
        {
            abort(404);
        }
    }

    public function addQuestion($request)
    {
        DB::beginTransaction();

        try {
            $questionsCount = Question::where('quiz_id', $request -> quizId)->count();

            if ($questionsCount >= 30) {
                return response()->json(['error' => trans('studentactivities/questions.max_questions_reached')], 400);
            }

            $question = Question::create([
                'question_text' => ['ar' => $request -> question_text_ar, 'en' => $request -> question_text_en],
                'degree' => $request -> degree,
                'quiz_id' => $request -> quizId,
            ]);

            foreach ($request -> answers_text_ar as $index => $answer) {
                Answer::create([
                    'answer_text' => ['ar' => $answer['value'], 'en' => $request -> answers_text_en[$index]['value']],
                    'is_correct' => ($answer['value'] == $request->is_correct_ar) ? true : false,
                    'question_id' => $question -> id,
                ]);
            }

            DB::commit();
            return response()->json(['success' => trans('studentactivities/questions.added')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function changeAnswer($request)
    {
        $question = Question::findOrFail($request -> question_id);
        $answerKey = 'customRadioTemp_' . $question -> id;

        if(!$request->input($answerKey))
        {
            return response()->json(['error' => trans('studentactivities/questions.required')], 400);
        }

        DB::beginTransaction();

        try{
            $answer = Answer::findOrFail($request -> input($answerKey));

            $question->answers()->update(['is_correct' => false]);
            $answer->update(['is_correct' => true]);

            DB::commit();
            return response()->json(['success' => trans('studentactivities/questions.answerChanged')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function editQuestion($request)
    {
        DB::beginTransaction();

        try {
            $question = Question::findOrFail($request -> id);
            $existingAnswers = $question->answers()->get()->keyBy('id');

            $question -> update([
                'question_text' => ['ar' => $request -> question_text_ar, 'en' => $request -> question_text_en],
                'degree' => $request -> degree,
            ]);

            foreach ($request -> answers_text_ar as $index => $answer) {
                if (isset($answer['id']) && $existingAnswers->has($answer['id'])) {
                    $existingAnswer = $existingAnswers->get($answer['id']);

                    $existingAnswer -> update([
                        'answer_text' => ['ar' => $answer['value'], 'en' => $request->answers_text_en[$index]['value']],
                        'is_correct' => ($answer['value'] === $request->is_correct_ar || $request->answers_text_en[$index]['value'] === $request->is_correct_en),
                    ]);

                    $existingAnswers->forget($answer['id']);
                } else {
                    Answer::create([
                        'answer_text' => ['ar' => $answer['value'], 'en' => $request -> answers_text_en[$index]['value']],
                        'is_correct' => ($answer['value'] === $request->is_correct_ar || $request->answers_text_en[$index]['value'] === $request->is_correct_en),
                        'question_id' => $question -> id,
                    ]);
                }
            }

            foreach ($existingAnswers as $remainingAnswer) {
                $remainingAnswer->delete();
            }

            DB::commit();
            return response()->json(['success' => trans('studentactivities/questions.edited')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function deleteQuestion($request)
    {
        Question::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('studentactivities/questions.deleted')]);
    }

    public function deleteSelectedQuestions($request)
    {
        $ids = explode("," , $request -> ids);

        Question::whereIn('id', $ids)->delete();

        return response()->json(['success' => trans('studentactivities/questions.deletedSelected')]);
    }
}

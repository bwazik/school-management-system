<?php

namespace App\Repositories\StudentActivities;

use App\Interfaces\StudentActivities\QuizRepositoryInterface;
use App\Models\Quiz;
use App\Models\Grade;
use App\Models\Stage;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;

class QuizRepository implements QuizRepositoryInterface
{
    public function getAllQuizzes($request)
    {
        if ($request->ajax()) {
            $quizzes = Quiz::select('id', 'name', 'stage_id', 'grade_id', 'classroom_id', 'subject_id', 'teacher_id')->get();
            return datatables()->of($quizzes)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->editColumn('name', function ($row) {
                    return $row -> name;
                })
                ->editColumn('stage_id', function ($row) {
                    return $row -> stage -> name;
                })
                ->editColumn('grade_id', function ($row) {
                    return $row -> grade -> name;
                })
                ->editColumn('classroom_id', function ($row) {
                    return $row -> classroom -> name;
                })
                ->editColumn('subject_id', function ($row) {
                    return $row -> subject -> name;
                })
                ->editColumn('teacher_id', function ($row) {
                    return '<a href='.route('teacherDetails', $row -> teacher_id).' target="_blank">'.$row -> teacher -> name.'</a>';
                })
                ->addColumn('actions', function ($row) {
                    return
                        '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    href="'.route('questions', $row -> id).'" class="dropdown-item d-flex align-items-center">
                                    '.trans('studentactivities/quizzes.questions').'
                                </a>
                                <a
                                    id="edit-quiz-button" data-bs-toggle="offcanvas" data-bs-target="#edit-quiz-modal"
                                    aria-controls="edit-quiz-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                                    data-stage_id="'.$row -> stage_id.'" data-grade_id="'.$row -> grade_id.'" data-classroom_id="'.$row -> classroom_id.'"
                                    data-subject_id="'.$row -> subject_id.'" data-teacher_id="'.$row -> teacher_id.'">
                                    '.trans('studentactivities/quizzes.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-quiz-button" data-bs-toggle="modal" data-bs-target="#delete-quiz-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('studentactivities/quizzes.delete').'
                                </a>
                            </div>
                        </div>
                        ';
                })

                ->rawColumns(['selectbox', 'term', 'teacher_id', 'actions'])
                ->make(true);
        }

        $stages = Stage::select('id', 'name')->orderBy('id')->get();
        $grades = Grade::select('id', 'name', 'stage_id')->orderBy('id')->get();
        $classrooms = Classroom::select('id', 'name', 'stage_id', 'grade_id')->orderBy('id')->get();
        $subjects = Subject::select('id', 'name')->orderBy('id')->get();
        $teachers = Teacher::select('id', 'name')->orderBy('id')->get();

        return view('studentactivities.quizzes.index', compact('stages', 'grades', 'classrooms', 'subjects', 'teachers'));
    }

    public function addQuiz($request)
    {
        Quiz::create([
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
            'stage_id' => $request -> stage_id,
            'grade_id' => $request -> grade_id,
            'classroom_id' => $request -> classroom_id,
            'subject_id' => $request -> subject_id,
            'teacher_id' => $request -> teacher_id,
        ]);

        return response()->json(['success' => trans('studentactivities/quizzes.added')]);
    }

    public function editQuiz($request)
    {
        $quiz = Quiz::findOrFail($request -> id);

        $quiz -> update([
            $quiz -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
            'stage_id' => $request -> stage_id,
            'grade_id' => $request -> grade_id,
            'classroom_id' => $request -> classroom_id,
            'subject_id' => $request -> subject_id,
            'teacher_id' => $request -> teacher_id,
        ]);

        return response()->json(['success' => trans('studentactivities/quizzes.edited')]);
    }

    public function deleteQuiz($request)
    {
        Quiz::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('studentactivities/quizzes.deleted')]);
    }

    public function deleteSelectedQuizzes($request)
    {
        $ids = explode("," , $request -> ids);

        Quiz::whereIn('id', $ids)->delete();

        return response()->json(['success' => trans('studentactivities/quizzes.deletedSelected')]);
    }
}

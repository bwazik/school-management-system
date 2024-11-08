<?php

namespace App\Repositories\SchoolManagement;

use App\Interfaces\SchoolManagement\GradeRepositoryInterface;
use App\Models\Grade;
use App\Models\Stage;

class GradeRepository implements GradeRepositoryInterface
{
    public function getAllGrades($request)
    {
        if ($request->ajax()) {
            $grades = Grade::select('id', 'name', 'stage_id', 'created_at')->get();
            return datatables()->of($grades)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->addColumn('name', function ($row) {
                    return $row -> name;
                })
                ->addColumn('stage_id', function ($row) {
                    return $row -> stage -> name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row -> created_at -> diffForHumans();
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    id="edit-grade-button" data-bs-toggle="offcanvas" data-bs-target="#edit-grade-modal"
                                    aria-controls="edit-grade-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'" data-stage_id="'.$row -> stage_id.'">
                                    '.trans('schoolmanagement/grades.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-grade-button" data-bs-toggle="modal" data-bs-target="#delete-grade-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('schoolmanagement/grades.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['selectbox', 'name', 'stage_id', 'created_at', 'actions'])
                ->make(true);
        }

        $stages = Stage::select('id', 'name')->orderBy('id')->get();

        return view('schoolmanagement.grades.index', compact('stages'));
    }

    public function addGrade($request)
    {
        Grade::create([
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
            'stage_id' => $request -> stage_id,
        ]);

        return response()->json(['success' => trans('schoolmanagement/grades.added')]);
    }

    public function editGrade($request)
    {
        $grade = Grade::findOrFail($request -> id);

        $grade -> update([
            $grade -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
            $grade -> stage_id = $request -> stage_id,
        ]);

        return response()->json(['success' => trans('schoolmanagement/grades.edited')]);
    }

    public function deleteGrade($request)
    {
        $gradesWithClassrooms = Grade::where('id', $request -> id)->whereHas('classrooms')->with('classrooms')->get();
        $gradeNames = $gradesWithClassrooms->pluck('name')->toArray();
        $gradeNamesString = implode(', ', $gradeNames);

        if ($gradesWithClassrooms->isEmpty()) {
            Grade::findOrFail($request -> id)->delete();

            return response()->json(['success' => trans('schoolmanagement/grades.deleted')]);
        }
        else
        {
            return response()->json(['error' => trans('schoolmanagement/grades.classroomsFound', ['grades' => $gradeNamesString])]);
        }
    }

    public function deleteSelectedGrades($request)
    {
        $ids = explode("," , $request -> ids);

        $gradesWithClassrooms = Grade::whereIn('id', $ids)->whereHas('classrooms')->with('classrooms')->get();

        if ($gradesWithClassrooms->isEmpty()) {
            Grade::whereIn('id', $ids)->delete();

            return response()->json(['success' => trans('schoolmanagement/grades.deletedSelected')]);
        }
        else
        {
            $gradeNames = $gradesWithClassrooms->pluck('name')->toArray();
            $gradeNamesString = implode(', ', $gradeNames);

            return response()->json(['error' => trans('schoolmanagement/grades.classroomsFound', ['grades' => $gradeNamesString])]);
        }
    }

    public function filterByStage($request)
    {
        if ($request->ajax()) {
            $grades = Grade::select('id', 'name', 'stage_id', 'created_at')->where('stage_id', $request -> id)->get();
            return datatables()->of($grades)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->addColumn('name', function ($row) {
                    return $row -> name;
                })
                ->addColumn('stage_id', function ($row) {
                    return $row -> stage -> name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row -> created_at -> diffForHumans();
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    id="edit-grade-button" data-bs-toggle="offcanvas" data-bs-target="#edit-grade-modal"
                                    aria-controls="edit-grade-modal" class="dropdown-item" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'" data-stage_id="'.$row -> stage_id.'">
                                    <i class="ti ti-pencil me-1"></i> Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-grade-button" data-bs-toggle="modal" data-bs-target="#delete-grade-modal"
                                    class="dropdown-item text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    <i class="ti ti-trash ti-sm me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['selectbox', 'name', 'stage_id', 'created_at', 'actions'])
                ->make(true);
        }
    }
}

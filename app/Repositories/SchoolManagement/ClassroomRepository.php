<?php

namespace App\Repositories\SchoolManagement;

use App\Interfaces\SchoolManagement\ClassroomRepositoryInterface;
use App\Models\Stage;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\Teacher;

class ClassroomRepository implements ClassroomRepositoryInterface
{
    public function getStagesWithClassrooms()
    {
        $stagesWithClassrooms = Stage::with(['classrooms'])->select('id', 'name')->orderBy('id')->get();
        $grades = Grade::select('id', 'name', 'stage_id')->orderBy('id')->get();
        $teachers = Teacher::select('id', 'name')->orderBy('id')->get();

        return view('schoolmanagement.classrooms.index', compact('stagesWithClassrooms', 'grades', 'teachers'));
    }

    public function getAllClassrooms($request, $stageId)
    {
        if ($request->ajax()) {
            $classrooms = Classroom::where('stage_id', $stageId)->select('id', 'name', 'stage_id', 'grade_id', 'status', 'created_at')->get();
            return datatables()->of($classrooms)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row -> name;
                })
                ->addColumn('grade_id', function ($row) {
                    return $row -> grade -> name;
                })
                ->editColumn('status', function ($row) {
                    if ($row -> status == 0){
                        return '<span class="badge bg-label-secondary" text-capitalized="">'.trans('schoolmanagement/classrooms.inactive').'</span>';
                    }
                    elseif($row -> status == 1){
                        return '<span class="badge bg-label-success" text-capitalized="">'.trans('schoolmanagement/classrooms.active').'</span>';
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row -> created_at -> diffForHumans();
                })
                ->addColumn('actions', function ($row) {
                    $teacherIds = $row->teachers->pluck('id')->toArray();
                    $teachers = implode(',', $teacherIds);
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    id="edit-classroom-button" data-bs-toggle="offcanvas" data-bs-target="#edit-classroom-modal"
                                    aria-controls="edit-classroom-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                                    data-id="'.$row -> id.'" data-stage_id="'.$row -> stage_id.'" data-grade_id="'.$row -> grade_id.'"
                                    data-teachers="'.$teachers.'" data-status="'.$row -> status.'">
                                    '.trans('schoolmanagement/classrooms.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-classroom-button" data-bs-toggle="modal" data-bs-target="#delete-classroom-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                                    data-id="'.$row -> id.'" data-stage_id="'.$row -> stage_id.'">
                                    '.trans('schoolmanagement/classrooms.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['name', 'grade_id', 'status', 'created_at', 'actions'])
                ->make(true);
        }
    }

    public function getGradesByAjax($id)
    {
        $grades = Grade::where('stage_id', $id)->pluck('name', 'id');

        return $grades;
    }

    public function getClassroomsByAjax($id)
    {
        $classrooms = Classroom::where('grade_id', $id)->pluck('name', 'id');

        return $classrooms;
    }

    public function getTeachersByAjax($id)
    {
        $teachers = Classroom::findOrFail($id)->teachers()->select('teachers.id', 'teachers.name')->pluck('name', 'id');

        return $teachers;
    }

    public function addClassroom($request)
    {
        $classroom = Classroom::create([
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
            'stage_id' => $request -> stage_id,
            'grade_id' => $request -> grade_id,
            'status' => $request -> status,
        ]);

        $classroom->teachers()->attach($request -> teachers);

        return response()->json(['success' => trans('schoolmanagement/classrooms.added')]);
    }

    public function editClassroom($request)
    {
        $classroom = Classroom::findOrFail($request -> id);

        if (isset($request -> teachers)) {
            $classroom->teachers()->sync($request -> teachers);
        } else {
            $classroom->teachers()->sync(array());
        }

        $classroom -> update([
            $classroom -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
            $classroom -> stage_id = $request -> stage_id,
            $classroom -> grade_id = $request -> grade_id,
            $classroom -> status = $request -> status,
        ]);

        return response()->json(['success' => trans('schoolmanagement/classrooms.edited')]);
    }

    public function deleteClassroom($request)
    {
        Classroom::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('schoolmanagement/classrooms.deleted')]);
    }
}

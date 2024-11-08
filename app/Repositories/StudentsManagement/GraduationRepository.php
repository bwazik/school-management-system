<?php

namespace App\Repositories\StudentsManagement;

use App\Interfaces\StudentsManagement\GraduationRepositoryInterface;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class GraduationRepository implements GraduationRepositoryInterface
{
    public function getAllGraduations($request)
    {
        if ($request->ajax()) {
            $students = Student::onlyTrashed()->select('id', 'email', 'name', 'stage_id', 'grade_id', 'classroom_id')->orderBy('id')->get();
            return datatables()->of($students)
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
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    href="'.route('studentDetails', $row -> id).'" class="dropdown-item d-flex align-items-center">
                                    '.trans('studentsmanagement/students.detail').'
                                </a>
                                <a
                                    id="return-student-button" data-bs-toggle="modal" data-bs-target="#return-student-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('studentsmanagement/students.revert').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-student-button" data-bs-toggle="modal" data-bs-target="#delete-student-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('studentsmanagement/students.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['selectbox', 'name', 'stage_id', 'grade_id', 'classroom_id', 'actions'])
                ->make(true);
        }

        $stages = Stage::select('id', 'name')->orderBy('id')->get();

        return view('studentsmanagement.graduations.index', compact('stages'));
    }

    public function addGraduation($request)
    {
        $students = Student::where('stage_id', $request -> stage_id)->where('grade_id', $request -> grade_id)->where('classroom_id',  $request -> classroom_id)->where('academic_year', $request -> academic_year)->get();

        $error = $students -> count() < 1;

        if($error)
        {
            return response()->json(['error' => trans('studentsmanagement/graduations.error')], 404);
        }

        foreach ($students as $student)
        {
            $ids = explode(',' , $student -> id);

            Student::whereIn('id', $ids)->delete();
        }

        return response()->json(['success' => trans('studentsmanagement/graduations.added')]);
    }

    public function returnStudent($request)
    {
        Student::withTrashed()->findOrFail($request -> id)->restore();

        return response()->json(['success' => trans('studentsmanagement/graduations.returned')]);
    }

    public function returnSelectedStudents($request)
    {
        $ids = explode("," , $request -> ids);

        Student::whereIn('id', $ids)->restore();

        return response()->json(['success' => trans('studentsmanagement/graduations.returnedSelected')]);
    }

    public function deleteStudent($request)
    {
        DB::beginTransaction();

        $student = Student::withTrashed()->findOrFail($request -> id);

        $attachments = Image::Where('imageable_type', 'App\Models\Student')->where('imageable_id', $request -> id)->get();

        if($attachments)
        {
            $file = new Filesystem;
            $file->deleteDirectory(Storage::disk('students')->path($student -> email));
            Image::where('imageable_type', 'App\Models\Student')->where('imageable_id', $request -> id)->delete();
        }

        $student->forceDelete();

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/graduations.deleted')]);
    }

    public function deleteSelectedStudents($request)
    {
        DB::beginTransaction();

        $ids = explode("," , $request -> ids);

        $attachments = Image::Where('imageable_type', 'App\Models\Student')->whereIn('imageable_id', $ids)->get();

        $emails = Student::whereIn('id', $ids)->select('email')->get();

        if (!$attachments->isEmpty()) {
            $file = new Filesystem;
            foreach ($emails as $email) {
                $file->deleteDirectory(Storage::disk('students')->path($email -> email));
            }
            Image::where('imageable_type', 'App\Models\Student')->whereIn('imageable_id', $ids)->delete();
        }

        Student::withTrashed()->whereIn('id', $ids)->forceDelete();

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/graduations.deletedSelected')]);
    }
}

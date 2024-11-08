<?php

namespace App\Repositories\StudentsManagement;

use App\Interfaces\StudentsManagement\PromotionRepositoryInterface;
use App\Models\Promotion;
use App\Models\Stage;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class PromotionRepository implements PromotionRepositoryInterface
{
    public function getAllPromotions($request)
    {
        if ($request->ajax()) {
            $promotions = Promotion::select('id', 'student_id', 'from_stage', 'from_grade', 'from_classroom', 'from_academic_year', 'to_stage', 'to_grade', 'to_classroom', 'to_academic_year')->orderBy('id')->get();
            return datatables()->of($promotions)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->editColumn('student_id', function ($row) {
                    return '<a href='.route('studentDetails', $row -> student_id).' target="_blank">'.$row -> student -> name.'</a>';
                })
                ->editColumn('from_stage', function ($row) {
                    return $row -> f_stage -> name;
                })
                ->editColumn('from_grade', function ($row) {
                    return $row -> f_grade -> name;
                })
                ->editColumn('from_classroom', function ($row) {
                    return $row -> f_classroom -> name;
                })
                ->editColumn('to_stage', function ($row) {
                    return $row -> t_stage -> name;
                })
                ->editColumn('to_grade', function ($row) {
                    return $row -> t_grade -> name;
                })
                ->editColumn('to_classroom', function ($row) {
                    return $row -> t_classroom -> name;
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    id="graduate-student-button" data-bs-toggle="modal" data-bs-target="#graduate-student-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> student -> getTranslation('name', 'ar').'" data-name_en="'.$row -> student -> getTranslation('name', 'en').'">
                                    '.trans('studentsmanagement/students.graduate').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="revert-student-button" data-bs-toggle="modal" data-bs-target="#revert-student-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> student -> getTranslation('name', 'ar').'" data-name_en="'.$row -> student -> getTranslation('name', 'en').'">
                                    '.trans('studentsmanagement/students.revert').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['selectbox', 'student_id', 'from_stage', 'from_grade', 'from_classroom', 'to_stage', 'to_grade', 'to_classroom', 'actions'])
                ->make(true);
        }

        $stages = Stage::select('id', 'name')->orderBy('id')->get();

        return view('studentsmanagement.promotions.index', compact('stages'));
    }

    public function addPromotion($request)
    {
        DB::beginTransaction();

        $students = Student::where('stage_id', $request -> from_stage_id)->where('grade_id', $request -> from_grade_id)->where('classroom_id',  $request -> from_classroom_id)->where('academic_year', $request -> from_academic_year)->get();

        $error1 = $students -> count() < 1;
        $error2 = $request -> from_stage_id == $request -> to_stage_id && $request -> from_grade_id == $request -> to_grade_id && $request -> from_classroom_id == $request -> to_classroom_id && $request -> from_academic_year == $request -> to_academic_year;

        if($error1)
        {
            return response()->json(['error' => trans('studentsmanagement/promotions.error1')], 404);
        }
        elseif($error2)
        {
            return response()->json(['error' => trans('studentsmanagement/promotions.error2')], 405);
        }

        foreach ($students as $student)
        {
            $ids = explode(',' , $student -> id);

            Student::whereIn('id' , $ids)->update([
                'stage_id' => $request -> to_stage_id,
                'grade_id' => $request -> to_grade_id,
                'classroom_id' => $request -> to_classroom_id,
                'academic_year' => $request -> to_academic_year,
            ]);

            Promotion::updateOrCreate([
                'student_id' => $student -> id,
                'from_stage' => $request -> from_stage_id,
                'from_grade' => $request -> from_grade_id,
                'from_classroom' => $request -> from_classroom_id,
                'from_academic_year' => $request -> from_academic_year,
                'to_stage' => $request -> to_stage_id,
                'to_grade' => $request -> to_grade_id,
                'to_classroom' => $request -> to_classroom_id,
                'to_academic_year' => $request -> to_academic_year,
            ]);
        }

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/promotions.added')]);
    }

    public function revertStudent($request)
    {
        DB::beginTransaction();

        $promotion = Promotion::findorfail($request -> id);

        Student::where('id', $promotion -> student_id)
            ->update([
                'stage_id' => $promotion -> from_stage,
                'grade_id' => $promotion -> from_grade,
                'classroom_id' => $promotion -> from_classroom,
                'academic_year' => $promotion -> from_academic_year,
            ]);

        $promotion->delete();

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/promotions.reverted')]);
    }

    public function revertSelectedStudents($request)
    {
        DB::beginTransaction();

        $ids = explode("," , $request -> ids);

        $promotions = Promotion::whereIn('id', $ids)->select('*')->get();

        foreach($promotions as $promotion)
        {
            Student::where('id', $promotion -> student_id)
            ->update([
                'stage_id' => $promotion -> from_stage,
                'grade_id' => $promotion -> from_grade,
                'classroom_id' => $promotion -> from_classroom,
                'academic_year' => $promotion -> from_academic_year,
            ]);

            $promotion->delete();
        }

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/promotions.revertedSelected')]);
    }

    public function graduateStudent($request)
    {
        DB::beginTransaction();

        $promotion = Promotion::where('id', $request -> id)->select('id', 'student_id')->first();

        Student::where('id', $promotion -> student_id)->delete();

        $promotion->delete();

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/promotions.graduated')]);
    }

    public function graduateSelectedStudents($request)
    {
        $ids = explode("," , $request -> ids);

        $promotions = Promotion::whereIn('id', $ids)->select('id', 'student_id')->get();

        foreach($promotions as $promotion)
        {
            Student::where('id', $promotion -> student_id)->delete();

            $promotion->delete();
        }

        return response()->json(['success' => trans('studentsmanagement/promotions.graduatedSelected')]);
    }
}

<?php

namespace App\Repositories\StudentActivities;

use App\Interfaces\StudentActivities\AttendanceRepositoryInterface;
use App\Models\Student;
use App\Models\Stage;
use App\Models\Classroom;
use App\Models\Attendance;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function getStagesWithClassrooms()
    {
        $stagesWithClassrooms = Stage::with(['classrooms'])->select('id', 'name')->orderBy('id')->get();

        return view('studentactivities.attendances.index', compact('stagesWithClassrooms'));
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
                    return '
                        <a type="button" href="'.route('getStudentsWithAttendances', $row -> id).'" class="btn btn-sm btn-label-primary waves-effect">'.trans('studentactivities/attendances.students').'</a>
                    ';
                })

                ->rawColumns(['name', 'grade_id', 'status', 'created_at', 'actions'])
                ->make(true);
        }
    }

    public function getStudentsWithAttendances($request, $classroomId)
    {
        if ($request->ajax()) {
            $students = Student::with(['attendance'])->where('classroom_id', $classroomId)->select('id', 'name', 'email', 'stage_id', 'grade_id', 'classroom_id')->get();

            return datatables()->of($students)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row -> name;
                })
                ->addColumn('actions', function ($row) {

                    $attendance = $row->attendance()->where('date', date('Y-m-d'))->first();
                    $disabled = isset($attendance->student_id) ? 'disabled' : '';
                    $checked = isset($attendance) && $attendance->status == 1 ? 'checked' : '';
                    $cursor = isset($attendance->student_id) ? 'not-allowed' : 'pointer';
                    $cursorClass = 'style="cursor: '.$cursor.' !important;"';

                    if(!$disabled)
                    {
                        return '
                        <input type="hidden" name="status['.$row->id.']" value="0"/>
                        <label class="switch switch-square" '.$cursorClass.'>
                            <input type="checkbox" class="switch-input" name="status['.$row->id.']" value="1" '.$disabled.' '.$checked.'/>
                            <span class="switch-toggle-slider" '.$cursorClass.'>
                                <span class="switch-on"><i class="ti ti-check"></i></span>
                                <span class="switch-off"><i class="ti ti-x"></i></span>
                            </span>
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                            <input type="hidden" name="stage_id[]" value="' . $row->stage_id . '"/>
                            <input type="hidden" name="grade_id[]" value="' . $row->grade_id . '"/>
                            <input type="hidden" name="classroom_id[]" value="' . $row->classroom_id . '"/>
                        </label>
                        ';
                    }
                    else
                    {
                        return '
                        <label class="switch switch-square" '.$cursorClass.'>
                            <input type="checkbox" class="switch-input" '.$disabled.' '.$checked.'/>
                            <span class="switch-toggle-slider" '.$cursorClass.'>
                                <span class="switch-on"><i class="ti ti-check"></i></span>
                                <span class="switch-off"><i class="ti ti-x"></i></span>
                            </span>
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </label>
                        ';
                    }

                })
                ->rawColumns(['name', 'actions'])
                ->make(true);
        }

        return view('studentactivities.attendances.students', compact('classroomId'));
    }

    public function addAttendance($request)
    {
        try
        {
            if($request -> status)
            {
                foreach ($request -> status as $id => $status) {
                    Attendance::create([
                        'student_id'=> $id,
                        'stage_id'=> $request -> stage_id[$status],
                        'grade_id'=> $request -> grade_id[$status],
                        'classroom_id'=> $request -> classroom_id[$status],
                        'teacher_id'=> 1,
                        'date'=> date('Y-m-d'),
                        'status'=> $status,
                    ]);
                }

                return response()->json(['success' => trans('studentactivities/attendances.added')]);
            }
            else
            {
                return response()->json(['done' => trans('studentactivities/attendances.done')]);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}

<?php

namespace App\Repositories\StudentActivities;

use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Stage;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\OnlineClass;
use Jubaer\Zoom\Facades\Zoom;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StudentActivities\OnlineClassRepositoryInterface;

class OnlineClassRepository implements OnlineClassRepositoryInterface
{
    public function getAllOnlineClasses($request)
    {
        if ($request->ajax()) {
            $onlineClasses = OnlineClass::select('id', 'integration', 'stage_id', 'grade_id', 'classroom_id', 'teacher_id', 'meeting_id', 'topic', 'duration', 'password', 'start_time', 'start_url', 'join_url')->get();
            return datatables()->of($onlineClasses)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->editColumn('teacher_id', function ($row) {
                    return '<a href='.route('teacherDetails', $row -> teacher_id).' target="_blank">'.$row -> teacher -> name.'</a>';
                })
                ->editColumn('topic', function ($row) {
                    return $row -> topic;
                })
                ->editColumn('duration', function ($row) {
                    $minutes = $row->duration;
                    $hours = floor($minutes / 60);
                    $remainingMinutes = $minutes % 60;

                    if ($hours > 0) {
                        return $hours . ' ' . trans('studentactivities/onlineclasses.hours') . '' .
                        ($remainingMinutes > 0 ? ' ' . trans('studentactivities/onlineclasses.and') . ' ' .
                        $remainingMinutes . ' ' . trans('studentactivities/onlineclasses.minute') . '' : '');
                    }
                    return $remainingMinutes . ' ' . trans('studentactivities/onlineclasses.minutes') . '';
                })
                ->editColumn('start_time', function ($row) {
                    return \Carbon\Carbon::parse($row -> start_time)->diffForHumans();
                })
                ->editColumn('join_url', function ($row) {
                    return '<a href="'.$row -> join_url.'" target="_blank" class="btn btn-sm btn-label-danger waves-effect">'.trans('studentactivities/onlineclasses.join_now').'</a>';
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
                                    id="edit-online-class-button" data-bs-toggle="modal" data-bs-target="#edit-online-class-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-meeting_id="'.$row -> meeting_id.'" data-stage_id="'.$row -> stage_id.'"
                                    data-grade_id="'.$row -> grade_id.'" data-classroom_id="'.$row -> classroom_id.'" data-teacher_id="'.$row -> teacher_id.'"
                                    data-topic_ar="'.$row -> getTranslation('topic', 'ar').'" data-topic_en="'.$row -> getTranslation('topic', 'en').'"
                                    data-duration="'.$row -> duration.'" data-start_time="'.\Carbon\Carbon::parse($row -> start_time)->format('Y-m-d H:i').'">
                                    '.trans('studentactivities/onlineclasses.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-online-class-button" data-bs-toggle="modal" data-bs-target="#delete-online-class-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-meeting_id="'.$row -> meeting_id.'"
                                    data-topic_ar="'.$row -> getTranslation('topic', 'ar').'" data-topic_en="'.$row -> getTranslation('topic', 'en').'">
                                    '.trans('studentactivities/onlineclasses.delete').'
                                </a>
                            </div>
                        </div>
                        ';
                })
                ->rawColumns(['selectbox', 'teacher_id', 'join_url', 'actions'])
                ->make(true);
        }

        $stages = Stage::select('id', 'name')->orderBy('id')->get();
        $grades = Grade::select('id', 'name', 'stage_id')->orderBy('id')->get();
        $classrooms = Classroom::select('id', 'name', 'stage_id', 'grade_id')->orderBy('id')->get();
        $teachers = Teacher::select('id', 'name')->orderBy('id')->get();

        return view('studentactivities.onlineclasses.index', compact('stages', 'grades', 'classrooms', 'teachers'));
    }

    public function addOnlineClass($request)
    {
        DB::beginTransaction();

        try {
            $stage = Stage::where('id', $request -> stage_id)->pluck('name')->first();
            $grade = Grade::where('id', $request -> grade_id)->pluck('name')->first();
            $classroom = Classroom::where('id', $request -> classroom_id)->pluck('name')->first();
            $teacher = Teacher::where('id', $request -> teacher_id)->pluck('name')->first();
            $start_time = Carbon::createFromFormat('Y-m-d H:i', $request -> start_time, config('app.timezone'))
            ->setTimezone('UTC')
            ->addHours(2)
            ->toISOString();

            $meeting = Zoom::createMeeting([
                "agenda" => $stage . '-' . $grade . '-' . $classroom,
                "topic" => $request -> topic_ar . '-' . $request -> topic_en . '-'. $teacher,
                "duration" => $request -> duration,
                "timezone" => config('app.timezone'),
                "password" => $request -> password,
                "start_time" => $start_time,
                "settings" => [
                    'join_before_host' => false,
                    'host_video' => false,
                    'participant_video' => false,
                    'mute_upon_entry' => true,
                    'waiting_room' => true,
                    'audio' => 'both',
                    'auto_recording' => 'none',
                    'approval_type' => 1,
                ],
            ]);

            OnlineClass::create([
                'integration' => 1,
                'stage_id' => $request -> stage_id,
                'grade_id' => $request -> grade_id,
                'classroom_id' => $request -> classroom_id,
                'teacher_id' => $request -> teacher_id,
                'meeting_id' => $meeting['data']['id'],
                'topic' => ['en' => $request -> topic_en, 'ar' => $request -> topic_ar],
                'duration' =>  $request -> duration,
                'password' => $meeting['data']['password'] ?? $request -> password,
                'start_time' =>  $request -> start_time,
                'start_url' =>  $meeting['data']['start_url'],
                'join_url' =>  $meeting['data']['join_url'],
            ]);

            DB::commit();
            return response()->json(['success' => trans('studentactivities/onlineclasses.added')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An unexpected error occurred.' . $e], 500);
        }
    }

    public function editOnlineClass($request)
    {
        DB::beginTransaction();

        try {
            $stage = Stage::where('id', $request -> stage_id)->pluck('name')->first();
            $grade = Grade::where('id', $request -> grade_id)->pluck('name')->first();
            $classroom = Classroom::where('id', $request -> classroom_id)->pluck('name')->first();
            $teacher = Teacher::where('id', $request -> teacher_id)->pluck('name')->first();
            $onlineClass = OnlineClass::findOrFail($request -> id);
            $start_time = Carbon::createFromFormat('Y-m-d H:i', $request -> start_time, config('app.timezone'))
            ->setTimezone('UTC')
            ->addHours(2)
            ->toISOString();

            $meeting = Zoom::updateMeeting($request -> meeting_id, [
                "agenda" => $stage . '-' . $grade . '-' . $classroom,
                "topic" => $request -> topic_ar . '-' . $request -> topic_en . '-'. $teacher,
                "duration" => $request -> duration,
                "start_time" => $start_time,
            ]);

            $onlineClass->update([
                'stage_id' => $request -> stage_id,
                'grade_id' => $request -> grade_id,
                'classroom_id' => $request -> classroom_id,
                'teacher_id' => $request -> teacher_id,
                'topic' => ['en' => $request -> topic_en, 'ar' => $request -> topic_ar],
                'duration' =>  $request -> duration,
                'start_time' =>  $request -> start_time,
            ]);

            DB::commit();
            return response()->json(['success' => trans('studentactivities/onlineclasses.edited')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An unexpected error occurred.' . $e], 500);
        }
    }

    public function deleteOnlineClass($request)
    {
        try {
            OnlineClass::findOrFail($request -> id)->delete();
            $meeting = Zoom::deleteMeeting($request -> meeting_id);

            return response()->json(['success' => trans('studentactivities/onlineclasses.deleted')]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.' . $e], 500);
        }
    }

    public function deleteSelectedOnlineClasses($request)
    {
        try {
            $ids = explode("," , $request -> ids);
            $meetings = OnlineClass::whereIn('id', $ids)->get();

            foreach($meetings as $meeting)
            {
                if ($meeting -> meeting_id) {
                    Zoom::deleteMeeting($meeting -> meeting_id);
                }
            }
            OnlineClass::whereIn('id', $ids)->delete();

            return response()->json(['success' => trans('studentactivities/onlineclasses.deletedSelected')]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.' . $e], 500);
        }
    }
}

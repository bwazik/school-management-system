<?php

namespace App\Repositories\Users;

use App\Interfaces\Users\TeacherRepositoryInterface;
use App\Models\Gender;
use App\Models\Image;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function getAllTeachers($request)
    {
        if ($request->ajax()) {
            $teachers = Teacher::select('id', 'email', 'name', 'subject_id', 'gender_id', 'joining_date', 'address')->orderBy('id')->get();
            return datatables()->of($teachers)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->editColumn('name', function ($row) {
                    return $row -> name;
                })
                ->editColumn('subject_id', function ($row) {
                    return $row -> subject ? $row -> subject -> name : '-';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    href="'.route('teacherDetails', $row -> id).'" class="dropdown-item d-flex align-items-center">
                                    '.trans('users/teachers.detail').'
                                </a>
                                <a
                                    id="edit-teacher-button" data-bs-toggle="modal" data-bs-target="#edit-teacher-modal"
                                    data-id="'.$row -> id.'" data-email="'.$row -> email.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'"
                                    data-name_en="'.$row -> getTranslation('name', 'en').'" data-subject_id="'.$row -> subject_id.'"
                                    data-gender_id="'.$row -> gender_id.'" data-joining_date="'.$row -> joining_date.'" data-address="'.$row -> address.'"
                                    class="dropdown-item d-flex align-items-center"  href="javascript:void(0);">
                                    '.trans('users/teachers.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-teacher-button" data-bs-toggle="modal" data-bs-target="#delete-teacher-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'"
                                    data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('users/teachers.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['selectbox', 'name', 'subject_id', 'actions'])
                ->make(true);
        }

        $subjects = Subject::select('id', 'name')->orderBy('id')->get();
        $genders = Gender::select('id', 'name')->orderBy('id')->get();

        return view('users.teachers.index', compact('subjects', 'genders'));
    }

    public function addTeacher($request)
    {
        DB::beginTransaction();

        $teacher = Teacher::create([
            'email' => $request -> email,
            'password' => Hash::make($request -> password),
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
            'subject_id' => $request -> subject_id,
            'gender_id' => $request -> gender_id,
            'joining_date' => $request -> joining_date,
            'address' => $request -> address,
        ]);

        if ($request -> hasFile('attachment')){
            $name = $request -> attachment -> getClientOriginalName();
            $request -> attachment -> storeAs($request -> email, $name, 'teachers');

            Image::create([
                'file_name' => $name,
                'imageable_id' => $teacher -> id,
                'imageable_type' => 'App\Models\Teacher',
            ]);
        }

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('users/teachers.added')]);
    }

    public function editTeacher($request)
    {
        $teacher = Teacher::findOrFail($request->id);

        if (!empty($input['password'])) {
            $teacher->update([
                'email' => $request -> email,
                'password' => Hash::make($request -> password),
                'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
                'subject_id' => $request -> subject_id,
                'gender_id' => $request -> gender_id,
                'joining_date' => $request -> joining_date,
                'address' => $request -> address,
            ]);
        }
        else
        {
            $teacher->update([
                'email' => $request -> email,
                'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
                'subject_id' => $request -> subject_id,
                'gender_id' => $request -> gender_id,
                'joining_date' => $request -> joining_date,
                'address' => $request -> address,
            ]);
        }

        return response()->json(['success' => trans('users/teachers.edited')]);
    }

    public function deleteTeacher($request)
    {
        $teacher = Teacher::findOrFail($request -> id);

        $attachments = Image::Where('imageable_type', 'App\Models\Teacher')->where('imageable_id', $request -> id)->get();

        if($attachments)
        {
            $file = new Filesystem;
            $file->deleteDirectory(Storage::disk('teachers')->path($teacher -> email));
            Image::where('imageable_type', 'App\Models\Teacher')->where('imageable_id', $request -> id)->delete();
        }

        $teacher->delete();

        DB::commit();
        DB::rollback();
        return response()->json(['success' => trans('users/teachers.deleted')]);
    }

    public function deleteSelectedTeachers($request)
    {
        DB::beginTransaction();

        $ids = explode("," , $request -> ids);

        $attachments = Image::Where('imageable_type', 'App\Models\Teacher')->whereIn('imageable_id', $ids)->get();

        $emails = Teacher::whereIn('id', $ids)->select('email')->get();

        if (!$attachments->isEmpty()) {
            $file = new Filesystem;
            foreach ($emails as $email) {
                $file->deleteDirectory(Storage::disk('teachers')->path($email -> email));
            }
            Image::where('imageable_type', 'App\Models\Teacher')->whereIn('imageable_id', $ids)->delete();
        }

        Teacher::whereIn('id', $ids)->delete();

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('users/teachers.deletedSelected')]);
    }

    public function teacherDetails($id)
    {
        $attachments = Image::Where('imageable_type', 'App\Models\Teacher')->where('imageable_id', $id)->select('id', 'file_name', 'created_at')->get();
        $attachmentsCount = Image::Where('imageable_type', 'App\Models\Teacher')->where('imageable_id', $id)->count();
        $teacher = Teacher::where('id', $id)->select('id', 'email', 'name', 'subject_id', 'gender_id', 'joining_date', 'address')->first();

        return view('users.teachers.details', compact('attachments', 'attachmentsCount', 'teacher'));
    }

    public function addAttachment($request, $teacher_id)
    {
        if ($request -> hasFile('attachment')) {

            $teacher = Teacher::findOrFail($teacher_id);
            $email = $teacher -> email;

            $count = Image::where('imageable_type', 'App\Models\Teacher')->where('imageable_id', $teacher_id)->count();

            if($count < 2 )
            {
                $name = $request -> attachment -> getClientOriginalName();
                $request -> attachment -> storeAs($email, $name, 'teachers');

                Image::create([
                    'file_name' => $name,
                    'imageable_id' => $teacher -> id,
                    'imageable_type' => 'App\Models\Teacher',
                ]);

                return back()->with('added', trans('users/teachers.AttachmentAdded'));
            }
            else
            {
                return back()->with('count', trans('users/teachers.AttachmentsCount'));
            }

        }
        else
        {
            return back();
        }
    }

    public function showAttachment($email, $file)
    {
        return response()->file(storage_path('app/private/teachers/'.$email.'/'.$file));
    }

    public function downloadAttachment($email, $file)
    {
        return response()->download(storage_path('app/private/teachers/'.$email.'/'.$file));
    }

    public function deleteAttachment($id, $email, $file)
    {
        Storage::disk('teachers')->delete($email.'/'.$file);

        Image::where('imageable_type', 'App\Models\Teacher')->where('id', $id)->where('file_name', $file)->delete();

        return back()->with('deleted', trans('users/teachers.AttachmentDeleted'));
    }

    public function deleteAllTeacherAttachments($teacher_id)
    {
        $attchments = Image::where('imageable_type', 'App\Models\Teacher')->select('id')->get();
        Image::whereIn('id', $attchments)->delete();

        $file = new Filesystem;
        $teacher = Teacher::findOrFail($teacher_id);
        $email = $teacher -> email;
        $file->cleanDirectory(Storage::disk('teachers')->path($email));

        return back()->with('deletedAll', trans('users/teachers.AttachmentsDeletedAll'));
    }
}

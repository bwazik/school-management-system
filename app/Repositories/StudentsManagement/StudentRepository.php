<?php

namespace App\Repositories\StudentsManagement;

use App\Interfaces\StudentsManagement\StudentRepositoryInterface;
use App\Models\Blood;
use App\Models\Classroom;
use App\Models\Fee;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\Invoice;
use App\Models\MyParent;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\Stage;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentRepository implements StudentRepositoryInterface
{
    public function getAllStudents($request)
    {
        if ($request->ajax()) {
            $students = Student::select('id', 'email', 'name', 'gender_id', 'nationality', 'blood_type', 'religion', 'stage_id', 'grade_id', 'classroom_id', 'parent_id', 'birthday', 'academic_year')->orderBy('id')->get();
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

                    $feesIds = Fee::where('stage_id', $row -> stage_id)->where('grade_id' , $row -> grade_id)->pluck('id')->toArray();
                    $fees = implode(',' , $feesIds);

                    $student = StudentAccount::where('student_id', $row -> id)->select('debit', 'credit')->get();
                    $debit = $student->sum('debit');
                    $credit = $student->sum('credit');
                    $balance = number_format($debit - $credit, 2);

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
                                    id="edit-student-button" data-bs-toggle="modal" data-bs-target="#edit-student-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-email="'.$row -> email.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                                    data-gender_id="'.$row -> gender_id.'" data-nationality="'.$row -> nationality.'" data-blood_type="'.$row -> blood_type.'"
                                    data-religion="'.$row -> religion.'" data-stage_id="'.$row -> stage_id.'" data-grade_id="'.$row -> grade_id.'"
                                    data-classroom_id="'.$row -> classroom_id.'" data-parent_id="'.$row -> parent_id.'"
                                    data-birthday="'.$row -> birthday.'" data-academic_year="'.$row -> academic_year.'">
                                    '.trans('studentsmanagement/students.edit').'
                                </a>
                                <a
                                    id="graduate-student-button" data-bs-toggle="modal" data-bs-target="#graduate-student-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('studentsmanagement/students.graduate').'
                                </a>
                                <a
                                    id="add-invoice-button" data-bs-toggle="modal" data-bs-target="#add-invoice-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name="'.$row -> name.'" data-fees="'.$fees.'">
                                    '.trans('finance/invoices.addInvoice').'
                                </a>
                                <a
                                    id="add-receipt-button" data-bs-toggle="modal" data-bs-target="#add-receipt-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name="'.$row -> name.'" data-balance="'.$balance.'">
                                    '.trans('finance/receipts.addReceipt').'
                                </a>
                                <a
                                    id="add-payment-button" data-bs-toggle="modal" data-bs-target="#add-payment-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name="'.$row -> name.'" data-balance="'.$balance.'">
                                    '.trans('finance/payments.addPayment').'
                                </a>
                                <a
                                    id="add-refund-button" data-bs-toggle="modal" data-bs-target="#add-refund-modal"
                                    class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name="'.$row -> name.'" data-balance="'.$balance.'">
                                    '.trans('finance/refunds.addRefund').'
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
        $grades = Grade::select('id', 'name', 'stage_id')->orderBy('id')->get();
        $classrooms = Classroom::select('id', 'name', 'stage_id', 'grade_id')->orderBy('id')->get();
        $parents = MyParent::select('id', 'father_name', 'mother_name')->orderBy('id')->get();
        $genders = Gender::select('id', 'name')->orderBy('id')->get();
        $nationalities = Nationality::select('id', 'name')->orderBy('id')->get();
        $bloods = Blood::select('id', 'name')->orderBy('id')->get();
        $religions = Religion::select('id', 'name')->orderBy('id')->get();
        $fees = Fee::select('id', 'name')->orderBy('id')->get();

        return view('studentsmanagement.students.index', compact('stages', 'grades', 'classrooms', 'parents', 'genders', 'nationalities', 'bloods', 'religions', 'fees'));
    }

    public function addStudent($request)
    {
        DB::beginTransaction();

        $student = Student::create([
            'email' => $request -> email,
            'password' => Hash::make($request -> password),
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
            'gender_id' => $request -> gender_id,
            'nationality' => $request -> nationality,
            'blood_type' => $request -> blood_type,
            'religion' => $request -> religion,
            'stage_id' => $request -> stage_id,
            'grade_id' => $request -> grade_id,
            'classroom_id' => $request -> classroom_id,
            'parent_id' => $request -> parent_id,
            'birthday' => $request -> birthday,
            'academic_year' => $request -> academic_year,
        ]);

        if ($request -> hasFile('attachment')){
            $name = $request -> attachment -> getClientOriginalName();
            $request -> attachment -> storeAs($request -> email, $name, 'students');

            Image::create([
                'file_name' => $name,
                'imageable_id' => $student -> id,
                'imageable_type' => 'App\Models\Student',
            ]);
        }

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/students.added')]);
    }

    public function editStudent($request)
    {
        $student = Student::findOrFail($request->id);

        if (!empty($input['password'])) {
            $student->update([
                'email' => $request -> email,
                'password' => Hash::make($request -> password),
                'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
                'gender_id' => $request -> gender_id,
                'nationality' => $request -> nationality,
                'blood_type' => $request -> blood_type,
                'religion' => $request -> religion,
                'stage_id' => $request -> stage_id,
                'grade_id' => $request -> grade_id,
                'classroom_id' => $request -> classroom_id,
                'parent_id' => $request -> parent_id,
                'birthday' => $request -> birthday,
                'academic_year' => $request -> academic_year,
            ]);
        }
        else
        {
            $student->update([
                'email' => $request -> email,
                'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
                'gender_id' => $request -> gender_id,
                'nationality' => $request -> nationality,
                'blood_type' => $request -> blood_type,
                'religion' => $request -> religion,
                'stage_id' => $request -> stage_id,
                'grade_id' => $request -> grade_id,
                'classroom_id' => $request -> classroom_id,
                'parent_id' => $request -> parent_id,
                'birthday' => $request -> birthday,
                'academic_year' => $request -> academic_year,
            ]);
        }

        return response()->json(['success' => trans('studentsmanagement/students.edited')]);
    }

    public function deleteStudent($request)
    {
        DB::beginTransaction();

        $student = Student::findOrFail($request -> id);

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

        return response()->json(['success' => trans('studentsmanagement/students.deleted')]);
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

        Student::whereIn('id', $ids)->forceDelete();

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('studentsmanagement/students.deletedSelected')]);
    }

    public function graduateStudent($request)
    {
        Student::where('id', $request -> id)->delete();

        return response()->json(['success' => trans('studentsmanagement/promotions.graduated')]);
    }

    public function graduateSelectedStudents($request)
    {
        $ids = explode("," , $request -> ids);

        Student::whereIn('id', $ids)->delete();

        return response()->json(['success' => trans('studentsmanagement/promotions.graduatedSelected')]);
    }

    public function studentDetails($id)
    {
        $attachments = Image::Where('imageable_type', 'App\Models\Student')->where('imageable_id', $id)->select('id', 'file_name', 'created_at')->get();
        $attachmentsCount = Image::Where('imageable_type', 'App\Models\Student')->where('imageable_id', $id)->count();
        $student = Student::withTrashed()->where('id', $id)->select('id', 'email', 'name', 'gender_id', 'nationality', 'blood_type', 'religion', 'stage_id', 'grade_id', 'classroom_id', 'parent_id', 'birthday', 'academic_year')->first();

        return view('studentsmanagement.students.details', compact('attachments', 'attachmentsCount', 'student'));
    }

    public function addAttachment($request, $student_id)
    {
        if ($request -> hasFile('attachment')) {

            $student = Student::findOrFail($student_id);
            $email = $student -> email;

            $count = Image::where('imageable_type', 'App\Models\Student')->where('imageable_id', $student_id)->count();

            if($count < 2 )
            {
                $name = $request -> attachment -> getClientOriginalName();
                $request -> attachment -> storeAs($email, $name, 'students');

                Image::create([
                    'file_name' => $name,
                    'imageable_id' => $student -> id,
                    'imageable_type' => 'App\Models\Student',
                ]);

                return back()->with('added', trans('studentsmanagement/students.AttachmentAdded'));
            }
            else
            {
                return back()->with('count', trans('studentsmanagement/students.AttachmentsCount'));
            }

        }
        else
        {
            return back();
        }
    }

    public function showAttachment($email, $file)
    {
        return response()->file(storage_path('app/private/students/'.$email.'/'.$file));
    }

    public function downloadAttachment($email, $file)
    {
        return response()->download(storage_path('app/private/students/'.$email.'/'.$file));
    }

    public function deleteAttachment($id, $email, $file)
    {
        Storage::disk('students')->delete($email.'/'.$file);

        Image::where('imageable_type', 'App\Models\Student')->where('id', $id)->where('file_name', $file)->delete();

        return back()->with('deleted', trans('studentsmanagement/students.AttachmentDeleted'));
    }

    public function deleteAllStudentAttachments($student_id)
    {
        $attchments = Image::where('imageable_type', 'App\Models\Student')->select('id')->get();
        Image::whereIn('id', $attchments)->delete();

        $file = new Filesystem;
        $student = Student::findOrFail($student_id);
        $email = $student -> email;
        $file->cleanDirectory(Storage::disk('students')->path($email));

        return back()->with('deletedAll', trans('studentsmanagement/students.AttachmentsDeletedAll'));
    }
}

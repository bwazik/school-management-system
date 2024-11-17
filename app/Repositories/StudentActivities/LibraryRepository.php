<?php

namespace App\Repositories\StudentActivities;

use App\Models\Grade;
use App\Models\Stage;
use App\Models\Library;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StudentActivities\LibraryRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

class LibraryRepository implements LibraryRepositoryInterface
{
    public function getAllBooks($request)
    {
        if ($request->ajax()) {
            $library = Library::select('id', 'title', 'file_name', 'stage_id', 'grade_id', 'classroom_id', 'teacher_id')->get();
            return datatables()->of($library)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->editColumn('title', function ($row) {
                    return $row -> title;
                })
                ->editColumn('teacher_id', function ($row) {
                    return '<a href='.route('teacherDetails', $row -> teacher_id).' target="_blank">'.$row -> teacher -> name.'</a>';
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
                        <form id="show-form-' . $row->id . '" action="' . url('admin/library/show/' . $row->teacher->email . '/' . $row->file_name) . '" method="POST" target="_blank">' . csrf_field() . '</form>
                        <form id="download-form-' . $row->id . '" action="' . url('admin/library/download/' . $row->teacher->email . '/' . $row->file_name) . '" method="POST" target="_blank">' . csrf_field() . '</form>
                        <button onclick="event.preventDefault();document.getElementById(\'show-form-' . $row->id . '\').submit();" class="btn btn-outline-info btn-sm waves-effect me-1"><i class="ti ti-eye"></i></button>
                        <button onclick="event.preventDefault();document.getElementById(\'download-form-' . $row->id . '\').submit();" class="btn btn-outline-success btn-sm waves-effect me-1"><i class="ti ti-download"></i></button>
                        <button id="edit-book-button" data-bs-toggle="modal" data-bs-target="#edit-book-modal"
                            data-id='. $row->id . ' data-title_ar='.$row -> getTranslation('title', 'ar').' data-title_en='.$row -> getTranslation('title', 'en').'
                            data-stage_id="'.$row -> stage_id.'" data-grade_id="'.$row -> grade_id.'" data-classroom_id="'.$row -> classroom_id.'"
                            class="btn btn-outline-warning btn-sm waves-effect me-1">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button id="delete-book-button" data-bs-toggle="modal" data-bs-target="#delete-book-modal"
                            data-id='. $row->id . ' data-title_ar='.$row -> getTranslation('title', 'ar').' data-title_en='.$row -> getTranslation('title', 'en').'
                            class="btn btn-outline-danger btn-sm waves-effect me-1">
                            <i class="ti ti-trash"></i>
                        </button>';
                })
                ->rawColumns(['selectbox', 'teacher_id', 'actions'])
                ->make(true);
        }

        $stages = Stage::select('id', 'name')->orderBy('id')->get();
        $grades = Grade::select('id', 'name', 'stage_id')->orderBy('id')->get();
        $classrooms = Classroom::select('id', 'name', 'stage_id', 'grade_id')->orderBy('id')->get();
        $teachers = Teacher::select('id', 'name')->orderBy('id')->get();

        return view('studentactivities.library.index', compact('stages', 'grades', 'classrooms', 'teachers'));
    }

    public function addBook($request)
    {
        if ($request -> hasFile('file')) {

            $teacher = Teacher::findOrFail($request -> teacher_id);
            $email = $teacher -> email;

            $count = Library::where('teacher_id', $request -> teacher_id)->count();

            if($count < 5 )
            {
                $name = $request->file->getClientOriginalName();
                $request->file->storeAs($email, $name, 'library');

                Library::create([
                    'title' => ['ar' => $request -> title_ar, 'en' => $request -> title_en],
                    'file_name' => $name,
                    'stage_id' => $request -> stage_id,
                    'grade_id' => $request -> grade_id,
                    'classroom_id' => $request -> classroom_id,
                    'teacher_id' => $request -> teacher_id,
                ]);

                return response()->json(['success' => trans('studentactivities/library.added')]);
            }
            else
            {
                return response()->json(['count' => trans('studentactivities/library.count')]);
            }
        }
        else
        {
            return response()->json(['error' => trans('studentactivities/library.no_file_found')]);
        }
    }

    public function showBook($teacher_email, $file_name)
    {
        $filePath = storage_path('app/private/library/' . $teacher_email . '/' . $file_name);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->file($filePath);
    }

    public function downloadBook($teacher_email, $file_name)
    {
        $filePath = storage_path('app/private/library/'.$teacher_email.'/'.$file_name);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    }

    public function editBook($request)
    {
        $book = Library::findOrFail($request -> id);

        $book -> update([
            $book -> title = ['en' => $request -> title_en, 'ar' => $request -> title_ar],
            'stage_id' => $request -> stage_id,
            'grade_id' => $request -> grade_id,
            'classroom_id' => $request -> classroom_id,
        ]);

        return response()->json(['success' => trans('studentactivities/library.edited')]);
    }

    public function deleteBook($request)
    {
        $book = Library::findOrFail($request -> id);
        $teacher_email = $book -> teacher -> email;
        $file_name = $book -> file_name;
        $filePath = $teacher_email . '/' . $file_name;

        if (Storage::disk('library')->exists($filePath)) {
            DB::beginTransaction();

            try {
                Storage::disk('library')->delete($filePath);
                $book->delete();

                DB::commit();
                return response()->json(['success' => trans('studentactivities/library.deleted')]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'An unexpected error occurred.'], 500);
            }
        }
        else
        {
            return response()->json(['error' => trans('studentactivities/library.file_not_found')]);
        }
    }

    public function deleteSelectedBooks($request)
    {
        $ids = explode("," , $request -> ids);
        $books = Library::whereIn('id', $ids)->select('id', 'teacher_id', 'file_name')->get();

        DB::beginTransaction();

        try {
            foreach($books as $book)
            {
                $teacher = Teacher::findOrFail($book -> teacher_id);
                $teacher_email = $teacher -> email;
                $filePath = $teacher_email . '/' . $book -> file_name;

                if (Storage::disk('library')->exists($filePath)) {
                    Storage::disk('library')->delete($filePath);
                }

                $book->delete();
            }

            DB::commit();
            return response()->json(['success' => trans('studentactivities/library.deletedSelected')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}

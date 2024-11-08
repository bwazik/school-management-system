<?php

namespace App\Repositories\SchoolManagement;

use App\Interfaces\SchoolManagement\SubjectRepositoryInterface;
use App\Models\Subject;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function getAllSubjects($request)
    {
        if ($request->ajax()) {
            $subjects = Subject::select('id', 'name', 'created_at')->get();
            return datatables()->of($subjects)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->addColumn('name', function ($row) {
                    return $row -> name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row -> created_at -> diffForHumans();
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
                                    id="edit-subject-button" data-bs-toggle="offcanvas" data-bs-target="#edit-subject-modal"
                                    aria-controls="edit-subject-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('schoolmanagement/subjects.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-subject-button" data-bs-toggle="modal" data-bs-target="#delete-subject-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('schoolmanagement/subjects.delete').'
                                </a>
                            </div>
                        </div>
                        ';
                })

                ->rawColumns(['selectbox', 'name', 'created_at', 'actions'])
                ->make(true);
        }

        return view('schoolmanagement.subjects.index');
    }

    public function addSubject($request)
    {
        Subject::create([
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
        ]);

        return response()->json(['success' => trans('schoolmanagement/subjects.added')]);
    }

    public function editSubject($request)
    {
        $subject = Subject::findOrFail($request -> id);

        $subject -> update([
            $subject -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
        ]);

        return response()->json(['success' => trans('schoolmanagement/subjects.edited')]);
    }

    public function deleteSubject($request)
    {
        Subject::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('schoolmanagement/subjects.deleted')]);
    }

    public function deleteSelectedSubjects($request)
    {
        $ids = explode("," , $request -> ids);

        Subject::whereIn('id', $ids)->delete();

        return response()->json(['success' => trans('schoolmanagement/subjects.deletedSelected')]);
    }
}

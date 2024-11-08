<?php

namespace App\Repositories\SchoolManagement;

use App\Interfaces\SchoolManagement\StageRepositoryInterface;
use App\Models\Stage;

class StageRepository implements StageRepositoryInterface
{
    public function getAllStages($request)
    {
        if ($request->ajax()) {
            $stages = Stage::select('id', 'name', 'created_at')->get();
            return datatables()->of($stages)
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
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    id="edit-stage-button" data-bs-toggle="offcanvas" data-bs-target="#edit-stage-modal"
                                    aria-controls="edit-stage-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('schoolmanagement/stages.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-stage-button" data-bs-toggle="modal" data-bs-target="#delete-stage-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('schoolmanagement/stages.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })


                ->rawColumns(['selectbox', 'name', 'created_at', 'actions'])
                ->make(true);
        }

        return view('schoolmanagement.stages.index');
    }

    public function addStage($request)
    {
        Stage::create([
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
        ]);

        return response()->json(['success' => trans('schoolmanagement/stages.added')]);
    }

    public function editStage($request)
    {
        $stage = Stage::findOrFail($request -> id);

        $stage -> update([
            $stage -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
        ]);

        return response()->json(['success' => trans('schoolmanagement/stages.edited')]);
    }

    public function deleteStage($request)
    {
        $stagesWithGrades = Stage::where('id', $request -> id)->whereHas('grades')->with('grades')->get();
        $stageNames = $stagesWithGrades->pluck('name')->toArray();
        $stageNamesString = implode(', ', $stageNames);

        if ($stagesWithGrades->isEmpty()) {
            Stage::findOrFail($request -> id)->delete();

            return response()->json(['success' => trans('schoolmanagement/stages.deleted')]);
            }
        else
        {
            return response()->json(['error' => trans('schoolmanagement/stages.gradesFound', ['stages' => $stageNamesString])]);
        }
    }

    public function deleteSelectedStages($request)
    {
        $ids = explode("," , $request -> ids);

        $stagesWithGrades = Stage::whereIn('id', $ids)->whereHas('grades')->with('grades')->get();

        if ($stagesWithGrades->isEmpty()) {
            Stage::whereIn('id', $ids)->delete();

            return response()->json(['success' => trans('schoolmanagement/stages.deletedSelected')]);
        }
        else
        {
            $stageNames = $stagesWithGrades->pluck('name')->toArray();
            $stageNamesString = implode(', ', $stageNames);

            return response()->json(['error' => trans('schoolmanagement/stages.gradesFound', ['stages' => $stageNamesString])]);
        }
    }
}

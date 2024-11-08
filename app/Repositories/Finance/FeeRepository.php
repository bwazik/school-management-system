<?php

namespace App\Repositories\Finance;

use App\Interfaces\Finance\FeeRepositoryInterface;
use App\Models\Fee;
use App\Models\Grade;
use App\Models\Stage;

class FeeRepository implements FeeRepositoryInterface
{
    public function getAllFees($request)
    {
        if ($request->ajax()) {
            $fees = Fee::select('id', 'name', 'amount', 'stage_id', 'grade_id', 'year', 'created_at')->get();
            return datatables()->of($fees)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="dt-checkboxes form-check-input box1">';
                    return $btn;
                })
                ->editColumn('name', function ($row) {
                    return $row -> name;
                })
                ->editColumn('amount', function ($row) {
                    return '$' . number_format($row -> amount, 2);
                })
                ->editColumn('stage_id', function ($row) {
                    return $row -> stage -> name;
                })
                ->editColumn('grade_id', function ($row) {
                    return $row -> grade -> name;
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
                                    id="edit-fee-button" data-bs-toggle="offcanvas" data-bs-target="#edit-fee-modal"
                                    aria-controls="edit-fee-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                                    data-amount="'.$row -> amount.'" data-stage_id="'.$row -> stage_id.'" data-grade_id="'.$row -> grade_id.'" data-year="'.$row -> year.'">
                                    '.trans('finance/fees.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-fee-button" data-bs-toggle="modal" data-bs-target="#delete-fee-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'">
                                    '.trans('finance/fees.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['selectbox', 'name', 'amount', 'stage_id', 'grade_id', 'created_at', 'actions'])
                ->make(true);
        }

        $stages = Stage::select('id', 'name')->orderBy('id')->get();
        $grades = Grade::select('id', 'name', 'stage_id')->orderBy('id')->get();

        return view('finance.fees.index', compact('stages', 'grades'));
    }

    public function addFee($request)
    {
        Fee::create([
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
            'amount' => $request -> amount,
            'stage_id' => $request -> stage_id,
            'grade_id' => $request -> grade_id,
            'year' => $request -> year,
        ]);

        return response()->json(['success' => trans('finance/fees.added')]);
    }

    public function editFee($request)
    {
        $fee = Fee::findOrFail($request -> id);

        $fee -> update([
            'name' => ['ar' => $request -> name_ar, 'en' => $request -> name_en],
            'amount' => $request -> amount,
            'stage_id' => $request -> stage_id,
            'grade_id' => $request -> grade_id,
            'year' => $request -> year,
        ]);

        return response()->json(['success' => trans('finance/fees.edited')]);
    }

    public function deleteFee($request)
    {
        Fee::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('finance/fees.deleted')]);
    }

    public function deleteSelectedFees($request)
    {
        $ids = explode("," , $request -> ids);

        Fee::whereIn('id', $ids)->delete();

        return response()->json(['success' => trans('finance/fees.deletedSelected')]);
    }

    public function getFeeAmount($id)
    {
        $fee = Fee::where('id', $id)->pluck('amount');

        return $fee;
    }
}

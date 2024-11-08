<?php

namespace App\Repositories\Finance;

use App\Interfaces\Finance\ReceiptRepositoryInterface;
use App\Models\Fund;
use App\Models\Receipt;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;

class ReceiptRepository implements ReceiptRepositoryInterface
{
    public function getAllReceipts($request)
    {
        if ($request->ajax()) {
            $receipts = Receipt::select('id', 'date', 'student_id', 'debit', 'description')->get();
            return datatables()->of($receipts)
                ->addIndexColumn()
                ->editColumn('student_id', function ($row) {
                    return '<a href='.route('studentDetails', $row -> student_id).' target="_blank">'.$row -> student -> name.'</a>';
                })
                ->editColumn('debit', function ($row) {
                    return '$' . number_format($row -> debit, 2);
                })
                ->editColumn('description', function ($row) {
                    return $row -> description == null ? '-' : $row -> description;
                })
                ->addColumn('actions', function ($row) {
                    $student = StudentAccount::where('student_id', $row -> student_id)->select('debit', 'credit')->get();

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
                                    id="edit-receipt-button" data-bs-toggle="offcanvas" data-bs-target="#edit-receipt-modal"
                                    aria-controls="edit-subject-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-student_id="'.$row -> student -> name.'" data-balance="'.$balance.'"
                                    data-amount="'.$row -> debit.'" data-description="'.$row -> description.'">
                                    '.trans('finance/receipts.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-receipt-button" data-bs-toggle="modal" data-bs-target="#delete-receipt-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-amount="'.$row -> debit.'" data-student="'.$row -> student -> name.'">
                                    '.trans('finance/receipts.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['student_id', 'actions'])
                ->make(true);
        }

        $students = Student::select('id', 'name')->orderBy('id')->get();

        return view('finance.receipts.index', compact('students'));
    }

    public function addStudentReceipt($request)
    {
        Student::findOrFail($request -> id);

        DB::beginTransaction();

        try {
            $receipt = Receipt::create([
                'date' => date('Y-m-d'),
                'student_id' => $request -> id,
                'debit' => $request -> amount,
                'description' => $request -> description,
            ]);

            Fund::create([
                'date' => date('Y-m-d'),
                'receipt_id' => $receipt -> id,
                'debit' => $request -> amount,
                'credit' => 0.00,
                'description' => $request -> description,
            ]);

            StudentAccount::create([
                'type' => 2,  // 2 = receipt
                'student_id' => $request -> id,
                'receipt_id' => $receipt -> id,
                'debit' => 0.00,
                'credit' => $request -> amount,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/receipts.added')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function addReceipt($request)
    {
        DB::beginTransaction();

        try {
            $receipt = Receipt::create([
                'date' => date('Y-m-d'),
                'student_id' => $request -> student_id,
                'debit' => $request -> amount,
                'description' => $request -> description,
            ]);

            Fund::create([
                'date' => date('Y-m-d'),
                'receipt_id' => $receipt -> id,
                'debit' => $request -> amount,
                'credit' => 0.00,
                'description' => $request -> description,
            ]);

            StudentAccount::create([
                'type' => 2,  // 2 = receipt
                'student_id' => $request -> student_id,
                'receipt_id' => $receipt -> id,
                'debit' => 0.00,
                'credit' => $request -> amount,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/receipts.added')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function editReceipt($request)
    {
        DB::beginTransaction();

        $receipt = Receipt::findOrFail($request -> id);
        $fund = Fund::where('receipt_id', $request -> id)->first();
        $account = StudentAccount::where('receipt_id', $request -> id)->first();

        try {
            $receipt->update([
                'debit' => $request -> amount,
                'description' => $request -> description,
            ]);

            $fund->update([
                'debit' => $request -> amount,
                'credit' => 0.00,
                'description' => $request -> description,
            ]);

            $account->update([
                'debit' => 0.00,
                'credit' => $request -> amount,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/receipts.edited')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function deleteReceipt($request)
    {
        DB::beginTransaction();

        try
        {
            Receipt::findOrFail($request->id)->delete();
            StudentAccount::where('receipt_id', $request->id)->delete();

            DB::commit();
            return response()->json(['success' => trans('finance/receipts.deleted')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

}

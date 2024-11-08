<?php

namespace App\Repositories\Finance;

use App\Interfaces\Finance\RefundRepositoryInterface;
use App\Models\Fund;
use App\Models\Refund;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;

class RefundRepository implements RefundRepositoryInterface
{
    public function getAllRefunds($request)
    {
        if ($request->ajax()) {
            $refunds = Refund::select('id', 'date', 'student_id', 'debit', 'description')->get();
            return datatables()->of($refunds)
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
                                    id="edit-refund-button" data-bs-toggle="offcanvas" data-bs-target="#edit-refund-modal"
                                    aria-controls="edit-subject-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-student_id="'.$row -> student -> name.'" data-balance="'.$balance.'"
                                    data-amount="'.$row -> debit.'" data-description="'.$row -> description.'">
                                    '.trans('finance/refunds.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-refund-button" data-bs-toggle="modal" data-bs-target="#delete-refund-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-amount="'.$row -> debit.'" data-student="'.$row -> student -> name.'">
                                    '.trans('finance/refunds.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['student_id', 'actions'])
                ->make(true);
        }

        $students = Student::select('id', 'name')->orderBy('id')->get();

        return view('finance.refunds.index', compact('students'));
    }

    public function addStudentRefund($request)
    {
        Student::findOrFail($request -> id);

        DB::beginTransaction();

        try {
            $refund = Refund::create([
                'date' => date('Y-m-d'),
                'student_id' => $request -> id,
                'debit' => $request -> amount,
                'description' => $request -> description,
            ]);

            StudentAccount::create([
                'type' => 3,  // 3 = refund
                'student_id' => $request -> id,
                'refund_id' => $refund -> id,
                'debit' => 0.00,
                'credit' => $request -> amount,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/refunds.added')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function getStudentBalance($id)
    {
        $student = StudentAccount::where('student_id', $id)->select('debit', 'credit')->get();

        if ($student) {

            $debit = $student->sum('debit');
            $credit = $student->sum('credit');
            $balance = number_format($debit - $credit, 2);

            return [
                'balance' => $balance,
            ];
        }
        else
        {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function addRefund($request)
    {
        DB::beginTransaction();

        try {
            $refund = Refund::create([
                'date' => date('Y-m-d'),
                'student_id' => $request -> student_id,
                'debit' => $request -> amount,
                'description' => $request -> description,
            ]);

            StudentAccount::create([
                'type' => 3,  // 3 = refund
                'student_id' => $request -> student_id,
                'refund_id' => $refund -> id,
                'debit' => 0.00,
                'credit' => $request -> amount,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/refunds.added')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function editRefund($request)
    {
        DB::beginTransaction();

        $refund = Refund::findOrFail($request -> id);
        $account = StudentAccount::where('refund_id', $request -> id)->first();

        try {
            $refund->update([
                'debit' => $request -> amount,
                'description' => $request -> description,
            ]);

            $account->update([
                'debit' => 0.00,
                'credit' => $request -> amount,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/refunds.edited')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function deleteRefund($request)
    {
        DB::beginTransaction();

        try
        {
            Refund::findOrFail($request->id)->delete();
            StudentAccount::where('refund_id', $request->id)->delete();

            DB::commit();
            return response()->json(['success' => trans('finance/refunds.deleted')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

}

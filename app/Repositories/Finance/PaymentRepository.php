<?php

namespace App\Repositories\Finance;

use App\Interfaces\Finance\PaymentRepositoryInterface;
use App\Models\Fund;
use App\Models\Payment;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function getAllPayments($request)
    {
        if ($request->ajax()) {
            $payments = Payment::select('id', 'date', 'student_id', 'credit', 'description')->get();
            return datatables()->of($payments)
                ->addIndexColumn()
                ->editColumn('student_id', function ($row) {
                    return '<a href='.route('studentDetails', $row -> student_id).' target="_blank">'.$row -> student -> name.'</a>';
                })
                ->editColumn('credit', function ($row) {
                    return '$' . number_format($row -> credit, 2);
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
                                    id="edit-payment-button" data-bs-toggle="offcanvas" data-bs-target="#edit-payment-modal"
                                    aria-controls="edit-subject-modal" class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-student_id="'.$row -> student -> name.'" data-balance="'.$balance.'"
                                    data-amount="'.$row -> credit.'" data-description="'.$row -> description.'">
                                    '.trans('finance/payments.edit').'
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    id="delete-payment-button" data-bs-toggle="modal" data-bs-target="#delete-payment-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-amount="'.$row -> credit.'" data-student="'.$row -> student -> name.'">
                                    '.trans('finance/payments.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['student_id', 'actions'])
                ->make(true);
        }

        $students = Student::select('id', 'name')->orderBy('id')->get();

        return view('finance.payments.index', compact('students'));
    }

    public function addStudentPayment($request)
    {
        Student::findOrFail($request -> id);

        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'date' => date('Y-m-d'),
                'student_id' => $request -> id,
                'credit' => $request -> amount,
                'description' => $request -> description,
            ]);

            Fund::create([
                'date' => date('Y-m-d'),
                'payment_id' => $payment -> id,
                'debit' => 0.00,
                'credit' => $request -> amount,
                'description' => $request -> description,
            ]);

            StudentAccount::create([
                'type' => 4,  // 4 = payment
                'student_id' => $request -> id,
                'payment_id' => $payment -> id,
                'debit' => $request -> amount,
                'credit' => 0.00,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/payments.added')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function addPayment($request)
    {
        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'date' => date('Y-m-d'),
                'student_id' => $request -> student_id,
                'credit' => $request -> amount,
                'description' => $request -> description,
            ]);

            Fund::create([
                'date' => date('Y-m-d'),
                'payment_id' => $payment -> id,
                'debit' => 0.00,
                'credit' => $request -> amount,
                'description' => $request -> description,
            ]);

            StudentAccount::create([
                'type' => 4,  // 4 = payment
                'student_id' => $request -> student_id,
                'payment_id' => $payment -> id,
                'debit' => $request -> amount,
                'credit' => 0.00,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/payments.added')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.' . $e], 500);
        }
    }

    public function editPayment($request)
    {
        DB::beginTransaction();

        $payment = Payment::findOrFail($request -> id);
        $fund = Fund::where('payment_id', $request -> id)->first();
        $account = StudentAccount::where('payment_id', $request -> id)->first();

        try {
            $payment->update([
                'credit' => $request -> amount,
                'description' => $request -> description,
            ]);

            $fund->update([
                'debit' => 0.00,
                'credit' => $request -> amount,
                'description' => $request -> description,
            ]);

            $account->update([
                'debit' => $request -> amount,
                'credit' => 0.00,
            ]);

            DB::commit();
            return response()->json(['success' => trans('finance/payments.edited')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }

    public function deletePayment($request)
    {
        DB::beginTransaction();

        try
        {
            Payment::findOrFail($request->id)->delete();
            StudentAccount::where('payment_id', $request->id)->delete();

            DB::commit();
            return response()->json(['success' => trans('finance/payments.deleted')]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return response()->json(['error' => 'Something went wrong on our end. Please try again in a few moments or contact support if the issue persists.'], 500);
        }
    }
}

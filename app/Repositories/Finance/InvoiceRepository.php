<?php

namespace App\Repositories\Finance;

use App\Interfaces\Finance\InvoiceRepositoryInterface;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getAllInvoices($request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::select('id', 'date', 'fee_id', 'amount', 'student_id', 'stage_id', 'grade_id')->get();
            return datatables()->of($invoices)
                ->addIndexColumn()
                ->editColumn('fee_id', function ($row) {
                    return $row -> fee -> name;
                })
                ->editColumn('amount', function ($row) {
                    return '$' . number_format($row -> amount, 2);
                })
                ->editColumn('student_id', function ($row) {
                    return '<a href='.route('studentDetails', $row -> student_id).' target="_blank">'.$row -> student -> name.'</a>';
                })
                ->editColumn('stage_id', function ($row) {
                    return $row -> stage -> name;
                })
                ->editColumn('grade_id', function ($row) {
                    return $row -> grade -> name;
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    id="delete-invoice-button" data-bs-toggle="modal" data-bs-target="#delete-invoice-modal"
                                    class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                    data-id="'.$row -> id.'" data-fee="'.$row -> fee -> name.'" data-amount="'.$row -> amount.'" data-student="'.$row -> student -> name.'">
                                    '.trans('finance/invoices.delete').'
                                </a>
                            </div>
                        </div>
                    ';
                })

                ->rawColumns(['fee_id', 'amount','student_id', 'stage_id', 'grade_id', 'actions'])
                ->make(true);
        }

        $students = Student::select('id', 'name', 'stage_id', 'grade_id')->orderBy('id')->get();

        return view('finance.invoices.index', compact('students'));
    }

    public function addStudentInvoice($request)
    {
        $student = Student::findOrFail($request -> id)->select('stage_id', 'grade_id')->first();

        DB::beginTransaction();

        $invoice = Invoice::create([
            'date' => date('Y-m-d'),
            'stage_id' => $student -> stage_id,
            'grade_id' => $student -> grade_id,
            'student_id' => $request -> id,
            'fee_id' => $request -> fee,
            'amount' => $request -> amount,
        ]);

        if($invoice)
        {
            StudentAccount::create([
                'type' => 1,  // 1 = invoice
                'invoice_id' => $invoice -> id,
                'student_id' => $request -> id,
                'debit' => $request -> amount,
                'credit' => 0.00,
            ]);

            DB::commit();
        }
        else
        {
            DB::rollback();
        }

        return response()->json(['success' => trans('finance/invoices.added')]);
    }

    public function getStudentDetails($id)
    {
        $student = Student::where('id', $id)->select('stage_id', 'grade_id')->first();

        if ($student) {
            $fees = Fee::where('stage_id', $student -> stage_id)->where('grade_id', $student -> grade_id)->pluck('name', 'id');

            return [
                'stage_id' => $student -> stage_id,
                'grade_id' => $student -> grade_id,
                'stage' => $student -> stage -> name,
                'grade' => $student -> grade -> name,
                'fees' => $fees
            ];
        }
        else
        {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function addInvoice($request)
    {
        DB::beginTransaction();

        $invoice = Invoice::create([
            'date'       => date('Y-m-d'),
            'stage_id'   => $request->stage_id,
            'grade_id'   => $request->grade_id,
            'student_id' => $request->student_id,
            'fee_id'     => $request->fees,
            'amount'     => $request->amount,
        ]);

        StudentAccount::create([
            'type'       => 1,  // 1 = invoice
            'invoice_id' => $invoice->id,
            'student_id' => $request->student_id,
            'debit'      => $invoice->amount,
            'credit'     => 0.00,
        ]);

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('finance/invoices.added')]);
    }

    public function deleteInvoice($request)
    {
        Invoice::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('finance/invoices.deleted')]);
    }
}

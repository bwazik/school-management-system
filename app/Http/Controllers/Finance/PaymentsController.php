<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Finance\ReceiptsRequest;
use App\Http\Requests\Finance\editReceiptRequest;
use App\Http\Requests\Finance\StudentReceiptRequest;
use App\Interfaces\Finance\PaymentRepositoryInterface;

class PaymentsController extends Controller
{
    protected $payment;

    public function __construct(PaymentRepositoryInterface $payment)
    {
        $this -> payment = $payment;
    }

    public function index(Request $request)
    {
        return $this -> payment -> getAllPayments($request);
    }

    public function addStudentPayment(StudentReceiptRequest $request)
    {
        return $this -> payment -> addStudentPayment($request);
    }

    public function add(ReceiptsRequest $request)
    {
        return $this -> payment -> addPayment($request);
    }

    public function edit(editReceiptRequest $request)
    {
        return $this -> payment -> editPayment($request);
    }

    public function delete(Request $request)
    {
        return $this -> payment -> deletePayment($request);
    }
}

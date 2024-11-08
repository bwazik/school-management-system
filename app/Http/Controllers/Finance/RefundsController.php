<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Finance\ReceiptsRequest;
use App\Http\Requests\Finance\editReceiptRequest;
use App\Http\Requests\Finance\StudentReceiptRequest;
use App\Interfaces\Finance\RefundRepositoryInterface;

class RefundsController extends Controller
{
    protected $refund;

    public function __construct(RefundRepositoryInterface $refund)
    {
        $this -> refund = $refund;
    }

    public function index(Request $request)
    {
        return $this -> refund -> getAllRefunds($request);
    }

    public function addStudentRefund(StudentReceiptRequest $request)
    {
        return $this -> refund -> addStudentRefund($request);
    }

    public function getStudentBalance($id)
    {
        return $this -> refund -> getStudentBalance($id);
    }

    public function add(ReceiptsRequest $request)
    {
        return $this -> refund -> addRefund($request);
    }

    public function edit(editReceiptRequest $request)
    {
        return $this -> refund -> editRefund($request);
    }

    public function delete(Request $request)
    {
        return $this -> refund -> deleteRefund($request);
    }
}

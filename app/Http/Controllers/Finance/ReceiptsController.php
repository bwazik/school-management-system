<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Finance\ReceiptsRequest;
use App\Http\Requests\Finance\editReceiptRequest;
use App\Http\Requests\Finance\StudentReceiptRequest;
use App\Interfaces\Finance\ReceiptRepositoryInterface;

class ReceiptsController extends Controller
{
    protected $receipt;

    public function __construct(ReceiptRepositoryInterface $receipt)
    {
        $this -> receipt = $receipt;
    }

    public function index(Request $request)
    {
        return $this -> receipt -> getAllReceipts($request);
    }

    public function addStudentReceipt(StudentReceiptRequest $request)
    {
        return $this -> receipt -> addStudentReceipt($request);
    }

    public function add(ReceiptsRequest $request)
    {
        return $this -> receipt -> addReceipt($request);
    }

    public function edit(editReceiptRequest $request)
    {
        return $this -> receipt -> editReceipt($request);
    }

    public function delete(Request $request)
    {
        return $this -> receipt -> deleteReceipt($request);
    }
}

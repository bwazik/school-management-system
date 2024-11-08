<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Finance\InvoicesRequest;
use App\Http\Requests\Finance\StudentInvoiceRequest;
use App\Interfaces\Finance\InvoiceRepositoryInterface;

class InvoicesController extends Controller
{
    protected $invoice;

    public function __construct(InvoiceRepositoryInterface $invoice)
    {
        $this -> invoice = $invoice;
    }

    public function index(Request $request)
    {
        return $this -> invoice -> getAllInvoices($request);
    }

    public function addStudentInvoice(StudentInvoiceRequest $request)
    {
        return $this -> invoice -> addStudentInvoice($request);
    }

    public function getStudentDetails($id)
    {
        return $this -> invoice -> getStudentDetails($id);
    }

    public function add(InvoicesRequest $request)
    {
        return $this -> invoice -> addInvoice($request);
    }

    public function delete(Request $request)
    {
        return $this -> invoice -> deleteInvoice($request);
    }
}

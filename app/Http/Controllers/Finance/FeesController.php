<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Finance\FeesRequest;
use App\Interfaces\Finance\FeeRepositoryInterface;

class FeesController extends Controller
{
    protected $fee;

    public function __construct(FeeRepositoryInterface $fee)
    {
        $this -> fee = $fee;
    }

    public function index(Request $request)
    {
        return $this -> fee -> getAllFees($request);
    }

    public function add(FeesRequest $request)
    {
        return $this -> fee -> addFee($request);
    }

    public function edit(FeesRequest $request)
    {
        return $this -> fee -> editFee($request);
    }

    public function delete(Request $request)
    {
        return $this -> fee -> deleteFee($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> fee -> deleteSelectedFees($request);
    }

    public function getFeeAmount($id)
    {
        return $this -> fee -> getFeeAmount($id);
    }
}

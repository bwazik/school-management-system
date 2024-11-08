<?php

namespace App\Http\Controllers\StudentsManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudentsManagement\PromotionsRequest;
use App\Interfaces\StudentsManagement\PromotionRepositoryInterface;

class PromotionsController extends Controller
{
    protected $promotion;

    public function __construct(PromotionRepositoryInterface $promotion)
    {
        $this -> promotion = $promotion;
    }

    public function index(Request $request)
    {
        return $this -> promotion -> getAllPromotions($request);
    }

    public function add(PromotionsRequest $request)
    {
        return $this -> promotion -> addPromotion($request);
    }

    public function revert(Request $request)
    {
        return $this -> promotion -> revertStudent($request);
    }

    public function revertSelected(Request $request)
    {
        return $this -> promotion -> revertSelectedStudents($request);
    }

    public function graduate(Request $request)
    {
        return $this -> promotion -> graduateStudent($request);
    }

    public function graduateSelected(Request $request)
    {
        return $this -> promotion -> graduateSelectedStudents($request);
    }
}

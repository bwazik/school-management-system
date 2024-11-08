<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Users\ParentsRequest;
use App\Interfaces\Users\ParentRepositoryInterface;

class ParentsController extends Controller
{
    protected $parent;

    public function __construct(ParentRepositoryInterface $parent)
    {
        $this -> parent = $parent;
    }

    public function delete(Request $request)
    {
        return $this -> parent -> deleteParent($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> parent -> deleteSelectedParents($request);
    }

    public function parentDetails($id)
    {
        return $this -> parent -> parentDetails($id);
    }

    public function addAttachment(ParentsRequest $request, $parent_id)
    {
        return $this -> parent -> addAttachment($request, $parent_id);
    }

    public function showAttachment($father_national_id, $file)
    {
        return $this -> parent -> showAttachment($father_national_id, $file);
    }

    public function downloadAttachment($father_national_id, $file)
    {
        return $this -> parent -> downloadAttachment($father_national_id, $file);
    }

    public function deleteAttachment($id, $father_national_id, $file)
    {
        return $this -> parent -> deleteAttachment($id, $father_national_id, $file);
    }

    public function deleteAllAttachments($parent_id): mixed
    {
        return $this -> parent -> deleteAllParentAttachments($parent_id);
    }
}

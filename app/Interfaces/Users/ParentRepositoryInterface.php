<?php

namespace App\Interfaces\Users;

interface ParentRepositoryInterface
{
    public function deleteParent($request);

    public function deleteSelectedParents($request);

    public function parentDetails($id);

    public function addAttachment($request, $parent_id);

    public function showAttachment($father_national_id, $file);

    public function downloadAttachment($father_national_id, $file);

    public function deleteAttachment($id, $father_national_id, $file);

    public function deleteAllParentAttachments($parent_id);
}

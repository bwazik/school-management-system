<?php

namespace App\Interfaces\StudentActivities;

interface OnlineClassRepositoryInterface
{
    public function getAllOnlineClasses($request);

    public function addOnlineClass($request);

    public function editOnlineClass($request);

    public function deleteOnlineClass($request);

    public function deleteSelectedOnlineClasses($request);
}

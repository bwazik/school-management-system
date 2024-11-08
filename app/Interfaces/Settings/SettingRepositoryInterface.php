<?php

namespace App\Interfaces\Settings;

interface SettingRepositoryInterface
{
    public function settings();

    public function editSettings($request);
}

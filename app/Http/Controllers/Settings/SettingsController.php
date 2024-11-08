<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingsRequest;
use App\Interfaces\Settings\SettingRepositoryInterface;

class SettingsController extends Controller
{
    protected $setting;

    public function __construct(SettingRepositoryInterface $setting)
    {
        $this -> setting = $setting;
    }

    public function index()
    {
        return $this -> setting -> settings();
    }

    public function edit(SettingsRequest $request)
    {
        return $this -> setting -> editSettings($request);
    }
}

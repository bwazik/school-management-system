<?php

namespace App\Repositories\Settings;

use App\Interfaces\Settings\SettingRepositoryInterface;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingRepository implements SettingRepositoryInterface
{
    public function settings()
    {
        $settings = Setting::select('*')->first();
        $timezones = \DateTimeZone::listIdentifiers();

        return view('settings.index', compact('settings', 'timezones'));
    }

    public function editSettings($request)
    {
        try {
            $settings = Setting::firstOrFail();

            if ($request->hasFile('school_logo')) {
                $oldLogoPath = public_path('assets/img/settings/' . basename($settings->school_logo));

                if (File::exists($oldLogoPath)) {
                    File::delete($oldLogoPath);
                }

                $newLogo = $request->file('school_logo');
                $newLogoName = 'school_logo_' . time() . '.' . $newLogo->getClientOriginalExtension();
                $newLogo->move(public_path('assets/img/settings'), $newLogoName);
                $settings->school_logo = $newLogoName;
            }

            $settings->update([
                'school_name' => ['en' => $request -> school_name_en, 'ar' => $request -> school_name_ar],
                'school_title' => $request->school_title,
                'school_phone' => $request->school_phone,
                'school_address' => ['en' => $request -> school_address_en, 'ar' => $request -> school_address_ar],
                'school_email' => $request->school_email,
                'default_language' => $request->default_language,
                'max_students_per_class' => $request->max_students_per_class,
                'timezone' => $request->timezone,
                'academic_year_start' => $request->academic_year_start,
                'academic_year_end' => $request->academic_year_end,
            ]);

            return response()->json(['success' => trans('settings/settings.edited')]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}

<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'school_name_en' => 'required|string|max:255',
            'school_name_ar' => 'required|string|max:255',
            'school_title' => 'required|string|max:255',
            'school_phone' => 'required|string|regex:/^\d{11}$/|min:11 ',
            'school_address_en' => 'required|string|max:255',
            'school_address_ar' => 'required|string|max:255',
            'school_email' => 'required|email|max:255',
            'default_language' => 'required|in:en,ar,fr,de',
            'timezone' => 'required|timezone',
            'max_students_per_class' => 'required|integer|min:1',
            'academic_year_start' => 'required|date|date_format:Y-m-d',
            'academic_year_end' => 'required|date|after:academic_year_start|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

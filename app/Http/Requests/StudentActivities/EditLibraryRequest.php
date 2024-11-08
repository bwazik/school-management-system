<?php

namespace App\Http\Requests\StudentActivities;

use Illuminate\Foundation\Http\FormRequest;

class EditLibraryRequest extends FormRequest
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
            'title_ar' => 'required | max:100',
            'title_en' => 'required | max:100',
            'stage_id' => 'required | integer | exists:stages,id',
            'grade_id' => 'required | integer | exists:grades,id',
            'classroom_id' => 'required | integer | exists:classrooms,id',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

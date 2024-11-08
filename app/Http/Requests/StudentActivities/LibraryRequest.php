<?php

namespace App\Http\Requests\StudentActivities;

use Illuminate\Foundation\Http\FormRequest;

class LibraryRequest extends FormRequest
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
            'teacher_id' => 'required | integer | exists:teachers,id',
            'file' => 'required | file | mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,txt,mp4,mov | max:2048',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

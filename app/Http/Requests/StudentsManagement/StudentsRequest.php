<?php

namespace App\Http\Requests\StudentsManagement;

use Illuminate\Foundation\Http\FormRequest;

class StudentsRequest extends FormRequest
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
            'email' => 'required | email | max:100 | unique:students,email',
            'password' => 'required | min:8 | max:50',
            'name_ar' => 'required | max:100',
            'name_en' => 'required | max:100',
            'gender_id' => 'required | integer',
            'nationality' => 'required | integer',
            'blood_type' => 'required | integer',
            'religion' => 'required | integer',
            'stage_id' => 'required | integer',
            'grade_id' => 'required | integer',
            'classroom_id' => 'required | integer',
            'parent_id' => 'required | integer',
            'birthday' => 'required | date | date_format:Y-m-d',
            'academic_year' => 'required | integer',
            'attachment' => 'image | max:1024 | mimes:jpg,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

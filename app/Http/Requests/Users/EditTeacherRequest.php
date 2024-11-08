<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class EditTeacherRequest extends FormRequest
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
            'email' => 'required | email | max:100 | unique:teachers,email,'.$this -> id,
            'password' => 'max:50',
            'name_ar' => 'required | max:100',
            'name_en' => 'required | max:100',
            'subject_id' => 'required | integer',
            'gender_id' => 'required | integer',
            'joining_date' => 'required | date | date_format:Y-m-d',
            'attachment' => 'image | max:1024 | mimes:jpg,jpeg,png',
            'address' => 'required | max:150',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

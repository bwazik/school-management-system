<?php

namespace App\Http\Requests\StudentsManagement;

use Illuminate\Foundation\Http\FormRequest;

class PromotionsRequest extends FormRequest
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
            'from_stage_id' => 'required | integer',
            'from_grade_id' => 'required | integer',
            'from_classroom_id' => 'required | integer',
            'from_academic_year' => 'required | integer',
            'to_stage_id' => 'required | integer',
            'to_grade_id' => 'required | integer',
            'to_classroom_id' => 'required | integer',
            'to_academic_year' => 'required | integer',

        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

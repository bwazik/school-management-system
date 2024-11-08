<?php

namespace App\Http\Requests\StudentActivities;

use Illuminate\Foundation\Http\FormRequest;

class AttendancesRequest extends FormRequest
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
            'stage_id.*' => 'required|integer|exists:stages,id', // Assuming you have a stages table
            'grade_id.*' => 'required|integer|exists:grades,id', // Assuming you have a grades table
            'classroom_id.*' => 'required|integer|exists:classrooms,id', // Assuming you have a classrooms table
            'status.*' => 'required|integer', // Assuming you just need to ensure it's a boolean value
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

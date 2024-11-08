<?php

namespace App\Http\Requests\StudentActivities;

use Illuminate\Foundation\Http\FormRequest;

class OnlineClassesRequest extends FormRequest
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
            'stage_id' => 'required | integer | exists:stages,id',
            'grade_id' => 'required | integer | exists:grades,id',
            'classroom_id' => 'required | integer | exists:classrooms,id',
            'teacher_id' => 'required | integer | exists:teachers,id',
            'topic_ar' => 'required | max:100',
            'topic_en' => 'required | max:100',
            'duration' => 'required | integer | min:1 | max:360',
            'start_time' => 'required | date | date_format:Y-m-d H:i',
            'password' => 'nullable | min:4 | max:8',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

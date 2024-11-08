<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
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
            'student_id' => 'required | integer |exists:students,id',
            'stage_id' => 'required | string | max:255',
            'grade_id' => 'required | string | max:255',
            'fees' => 'required | integer | exists:fees,id',
            'amount' => 'required | numeric | min:1',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class FeesRequest extends FormRequest
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
            'name_ar' => 'required | min:3 | max:100',
            'name_en' => 'required | min:3 | max:100',
            'amount' => 'required | numeric',
            'stage_id' => 'required | integer',
            'grade_id' => 'required | integer',
            'year' => 'required | integer',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

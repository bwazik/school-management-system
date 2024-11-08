<?php

namespace App\Http\Requests\StudentActivities;

use Illuminate\Foundation\Http\FormRequest;

class ChangeAnswerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        foreach ($this->all() as $key => $value) {
            if (strpos($key, 'customRadioTemp_') === 0) {
                $rules[$key] = 'required|integer|exists:answers,id';
            }
        }

        return $rules;
    }

    public function messages()
    {
        $locale = app()->getLocale();

        return [
            'required' => $locale === 'ar' ? 'هذا الحقل مطلوب.' : 'This field is required.',
            'integer' => $locale === 'ar' ? 'يجب أن يكون هذا الحقل رقمًا صحيحًا.' : 'This field must be an integer.',
            'exists' => $locale === 'ar' ? 'الإجابة المحددة غير موجودة.' : 'The selected answer does not exist.',
        ];
    }
}

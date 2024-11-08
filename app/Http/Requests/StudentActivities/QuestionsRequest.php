<?php

namespace App\Http\Requests\StudentActivities;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'answers_text_ar' => json_decode($this->answers_text_ar, true),
            'answers_text_en' => json_decode($this->answers_text_en, true),
        ]);
    }

    public function rules()
    {
        $arabicAnswers = is_array($this->input('answers_text_ar')) ? array_column($this->input('answers_text_ar'), 'value') : [];
        $englishAnswers = is_array($this->input('answers_text_en')) ? array_column($this->input('answers_text_en'), 'value') : [];

        return [
            'question_text_ar' => 'required | string | max:500',
            'question_text_en' => 'required | string | max:500',
            'degree' => 'required | numeric | min:1',
            'answers_text_ar' => 'required | array | min:2 | max:5',
            'answers_text_en' => 'required | array | min:2 | max:5',
            'answers_text_ar.*.value' => 'string | max:300', // Validate each Arabic answer
            'answers_text_en.*.value' => 'string | max:300', // Validate each Arabic answer
            'is_correct_ar' => ['required', 'string', Rule::in($arabicAnswers)],
            'is_correct_en' => ['required', 'string', Rule::in($englishAnswers)],
        ];
    }

    public function messages()
    {
        $locale = app()->getLocale();

        return [
            'question_text_ar.required' => $locale === 'ar' ? 'يجب إدخال نص السؤال باللغة العربية.' : 'The Arabic question text is required.',
            'question_text_en.required' => $locale === 'ar' ? 'يجب إدخال نص السؤال باللغة الإنجليزية.' : 'The English question text is required.',
            'degree.required' => $locale === 'ar' ? 'يجب إدخال الدرجة.' : 'The degree is required.',
            'answers_text_ar.required' => $locale === 'ar' ? 'يجب إدخال خيارات الإجابة باللغة العربية.' : 'The Arabic answer options are required.',
            'answers_text_en.required' => $locale === 'ar' ? 'يجب إدخال خيارات الإجابة باللغة الإنجليزية.' : 'The English answer options are required.',
            'answers_text_ar.array' => $locale === 'ar' ? 'يجب أن تكون خيارات الإجابة باللغة العربية مصفوفة.' : 'The Arabic answer options must be an array.',
            'answers_text_en.array' => $locale === 'ar' ? 'يجب أن تكون خيارات الإجابة باللغة الإنجليزية مصفوفة.' : 'The English answer options must be an array.',
            'answers_text_ar.max' => $locale === 'ar' ? 'يمكن أن تحتوي خيارات الإجابة باللغة العربية على 5 إجابات كحد أقصى.' : 'The Arabic answer options may not have more than 5 items.',
            'answers_text_ar.min' => $locale === 'ar' ? 'يمكن أن تحتوي خيارات الإجابة باللغة العربية على 2 إجابات كحد أدني.' : 'The Arabic answer options may not have more than 5 items.',
            'answers_text_en.max' => $locale === 'ar' ? 'يمكن أن تحتوي خيارات الإجابة باللغة الإنجليزية على 5 إجابات كحد أقصى.' : 'The English answer options may not have more than 5 items.',
            'answers_text_en.min' => $locale === 'ar' ? 'يمكن أن تحتوي خيارات الإجابة باللغة الإنجليزية على 2 إجابات كحد أدني.' : 'The English answer options may not have more than 5 items.',
            'answers_text_ar.*.value.string' => $locale === 'ar' ? 'يجب أن يكون نص الإجابة باللغة العربية نصًا.' : 'Each Arabic answer option must be a string.',
            'answers_text_ar.*.value.max' => $locale === 'ar' ? 'يجب أن لا يتجاوز نص الإجابة باللغة العربية 300 حرف.' : 'Each Arabic answer option may not be greater than 300 characters.',
            'answers_text_en.*.value.string' => $locale === 'ar' ? 'يجب أن يكون نص الإجابة باللغة الإنجليزية نصًا.' : 'Each English answer option must be a string.',
            'answers_text_en.*.value.max' => $locale === 'ar' ? 'يجب أن لا يتجاوز نص الإجابة باللغة الإنجليزية 300 حرف.' : 'Each English answer option may not be greater than 300 characters.',
            'is_correct_ar.required' => $locale === 'ar' ? 'يجب إدخال الإجابة الصحيحة باللغة العربية.' : 'The correct answer in Arabic is required.',
            'is_correct_en.required' => $locale === 'ar' ? 'يجب إدخال الإجابة الصحيحة باللغة الإنجليزية.' : 'The correct answer in English is required.',
            'is_correct_ar.in' => $locale === 'ar' ? 'الإجابة الصحيحة باللغة العربية يجب أن تكون واحدة من الإجابةات المدخلة.' : 'The correct answer in Arabic must be one of the entered options.',
            'is_correct_en.in' => $locale === 'ar' ? 'الإجابة الصحيحة باللغة الإنجليزية يجب أن تكون واحدة من الإجابةات المدخلة.' : 'The correct answer in English must be one of the entered options.',
            'degree.numeric' => $locale === 'ar' ? 'يجب أن تكون الدرجة رقمًا.' : 'The degree must be a number.',
            'degree.min' => $locale === 'ar' ? 'يجب أن تكون الدرجة على الأقل 1.' : 'The degree must be at least 1.',
        ];
    }
}

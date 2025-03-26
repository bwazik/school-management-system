<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" id="add-question-button"
                        data-bs-toggle="modal" data-bs-target="#add-question-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/questions.addQuestion') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/questions.deletSelected') }}</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($questionsWithAnswers -> isNotEmpty())
                <div class="form-check custom-option custom-option-basic">
                    <label class="form-check-label custom-option-content" for="select_all">
                        <input name="select_all" id="select_all" type="checkbox" class="dt-checkboxes form-check-input"
                            onclick="CheckAll('box1', this)">
                        <span class="custom-option-header">
                            <span class="h6 mb-0">{{ trans('studentactivities/questions.selectAll') }}</span>
                        </span>
                    </label>
                </div>
                <div class="accordion mt-3 accordion-bordered" id="accordionExample">
                    @php $i=0; @endphp
                    @foreach ($questionsWithAnswers as $question)
                        @php $i++; @endphp
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button collapsed d-flex align-items-start"
                                    data-bs-toggle="collapse" data-bs-target="#accordion-{{ $question->id }}"
                                    aria-expanded="false" aria-controls="accordion-{{ $question->id }}">
                                    <div class="d-flex align-items-center" style="width: 100%;">
                                        <div class="d-flex align-items-center me-2" style="white-space: nowrap;">
                                            <input type="checkbox" value="{{ $question->id }}"
                                                class="dt-checkboxes form-check-input box1 me-2">
                                            <span>{{ $i }}&nbsp;-</span>
                                        </div>
                                        <span class="question-text" style="overflow-wrap: anywhere;">
                                            {{ $question->question_text }}
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="accordion-{{ $question->id }}" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row">
                                        <form id="change-answer-form-{{ $question->id }}" action="{{ route('changeAnswer') }}" method="POST">
                                            @csrf
                                            @foreach ($question->answers as $answer)
                                                <div class="col-md-12 mt-2 mb-1">
                                                    <div
                                                        class="form-check custom-option custom-option-basic {{ $answer->is_correct == 1 ? 'checked' : '' }}">
                                                        <label class="form-check-label custom-option-content"
                                                            for="customRadioTemp_{{ $question->id }}_{{ $answer->id }}">
                                                            <input type="hidden" name="question_id" value="{{ $question -> id }}">
                                                            <input name="customRadioTemp_{{ $question->id }}"
                                                            class="form-check-input" type="radio" value="{{ $answer -> id }}"
                                                            id="customRadioTemp_{{ $question -> id }}_{{ $answer -> id }}"
                                                            @if ($answer->is_correct == 1) checked @endif >
                                                            <span class="custom-option-header">
                                                                <div class="answer-text" style="overflow-wrap: break-word;">
                                                                    <span class="h6 mb-0">{{ $answer->answer_text }}</span>
                                                                </div>
                                                                <span class="text-muted">
                                                                    @if ($answer->is_correct == 1)
                                                                        {{ $question->degree }}
                                                                    @else
                                                                        0
                                                                    @endif
                                                                    {{ trans('studentactivities/questions.degrees') }}
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-md-12 text-center mt-2 d-flex justify-content-center">
                                                <span class="invalid-feedback" id="customRadioTemp_{{ $question->id }}_error" role="alert">
                                                    <strong></strong>
                                                </span>
                                            </div>
                                            <div class="col-md-12 text-center mt-2 d-flex justify-content-center">
                                                <button id="change-answer-button-{{ $question->id }}" type="submit" class="btn btn-label-success btn-icon waves-effect me-2"><i
                                                        class="ti ti-check ti-sm"></i></button>
                                                <button id="edit-question-button" data-bs-toggle="modal"
                                                    data-bs-target="#edit-question-modal"
                                                    class="btn btn-label-warning btn-icon waves-effect me-2"
                                                    data-id="{{ $question->id }}"
                                                    data-question_text_ar="{{ $question->getTranslation('question_text', 'ar') }}"
                                                    data-question_text_en="{{ $question->getTranslation('question_text', 'en') }}"
                                                    data-answers_text = "{{ $question->answers()->get() }}" data-degree = "{{ $question->degree }}">
                                                    <i class="ti ti-pencil ti-sm"></i>
                                                </button>
                                                <button id="delete-question-button" data-bs-toggle="modal"
                                                    data-bs-target="#delete-question-modal"
                                                    class="btn btn-label-danger btn-icon waves-effect"
                                                    data-id="{{ $question->id }}"
                                                    data-question_text_ar="{{ $question->getTranslation('question_text', 'ar') }}"
                                                    data-question_text_en="{{ $question->getTranslation('question_text', 'en') }}">
                                                    <i class="ti ti-trash ti-sm"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-md">
                    <div class="form-check custom-option custom-option-icon checked">
                        <label class="form-check-label custom-option-content" for="customRadioIcon3">
                            <span class="custom-option-body">
                                <i class="menu-icon mdi mdi-clipboard-text-outline"></i>
                                <span class="custom-option-title"> {{ trans('studentactivities/questions.noQuestionsFound') }} </span>
                            </span>
                        </label>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Question -->
<div class="modal fade" id="add-question-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/questions.addQuestion') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-form" action="{{ route('addQuestion') }}" method="POST" autocomplete="off">
                    <input type="hidden" name="quizId" id="quizId" value="{{ $quizId }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="question_text_ar">{{ trans('studentactivities/questions.question_text_ar') }}</label>
                            <textarea rows="5" maxlength="500" id="question_text_ar" class="form-control" name="question_text_ar"
                                placeholder="ما هي عاصمة فلسطين؟"></textarea>
                            <span class="invalid-feedback" id="question_text_ar_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="question_text_en">{{ trans('studentactivities/questions.question_text_en') }}</label>
                            <textarea rows="5" maxlength="500" id="question_text_en" class="form-control" name="question_text_en"
                                placeholder="What is the capital of palestine?"></textarea>
                            <span class="invalid-feedback" id="question_text_en_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label for="answers_text_ar"
                                class="form-label">{{ trans('studentactivities/questions.answers_text_ar') }}</label>
                            <input id="answers_text_ar" class="form-control" name="answers_text_ar" value="مثال"
                                tabindex="-1">
                            <span class="invalid-feedback" id="answers_text_ar_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label for="answers_text_en"
                                class="form-label">{{ trans('studentactivities/questions.answers_text_en') }}</label>
                            <input id="answers_text_en" class="form-control" name="answers_text_en" value="Ex"
                                tabindex="-1">
                            <span class="invalid-feedback" id="answers_text_en_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="is_correct_ar">{{ trans('studentactivities/questions.is_correct_ar') }}</label>
                            <input type="text" id="is_correct_ar" class="form-control" name="is_correct_ar"
                                placeholder="اكتب الإجابة الصحيحة التي أدخلتها سابقًا بنفس النص لتجنب الأخطاء." />
                            <span class="invalid-feedback" id="is_correct_ar_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="is_correct_en">{{ trans('studentactivities/questions.is_correct_en') }}</label>
                            <input type="text" id="is_correct_en" class="form-control" name="is_correct_en"
                                placeholder="Write the correct answer you entered above, using the exact same text to avoid errors." />
                            <span class="invalid-feedback" id="is_correct_en_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label class="form-label"
                                for="degree">{{ trans('studentactivities/questions.degree') }}</label>
                            <input type="number" id="degree" class="form-control" name="degree"
                                placeholder="5">
                            <span class="invalid-feedback" id="degree_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/questions.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentactivities/questions.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Question -->
<div class="modal fade" id="edit-question-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/questions.editQuestion') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="edit-form" action="{{ route('editQuestion') }}" method="POST" autocomplete="off">
                    <input type="hidden" name="id" id="id" value="">
                    @csrf
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="question_text_ar">{{ trans('studentactivities/questions.question_text_ar') }}</label>
                            <textarea rows="5" maxlength="500" id="question_text_ar" class="form-control" name="question_text_ar"
                                placeholder="ما هي عاصمة فلسطين؟"></textarea>
                            <span class="invalid-feedback" id="question_text_ar_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="question_text_en">{{ trans('studentactivities/questions.question_text_en') }}</label>
                            <textarea rows="5" maxlength="500" id="question_text_en" class="form-control" name="question_text_en"
                                placeholder="What is the capital of palestine?"></textarea>
                            <span class="invalid-feedback" id="question_text_en_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label for="answers_text_ar"
                                class="form-label">{{ trans('studentactivities/questions.answers_text_ar') }}</label>
                            <input id="answers_text_ar" class="form-control" name="answers_text_ar" value=""
                                tabindex="-1">
                            <span class="invalid-feedback" id="answers_text_ar_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label for="answers_text_en"
                                class="form-label">{{ trans('studentactivities/questions.answers_text_en') }}</label>
                            <input id="answers_text_en" class="form-control" name="answers_text_en" value=""
                                tabindex="-1">
                            <span class="invalid-feedback" id="answers_text_en_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="is_correct_ar">{{ trans('studentactivities/questions.is_correct_ar') }}</label>
                            <input type="text" id="is_correct_ar" class="form-control" name="is_correct_ar"
                                placeholder="اكتب الإجابة الصحيحة التي أدخلتها سابقًا بنفس النص لتجنب الأخطاء." />
                            <span class="invalid-feedback" id="is_correct_ar_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="is_correct_en">{{ trans('studentactivities/questions.is_correct_en') }}</label>
                            <input type="text" id="is_correct_en" class="form-control" name="is_correct_en"
                                placeholder="Write the correct answer you entered above, using the exact same text to avoid errors." />
                            <span class="invalid-feedback" id="is_correct_en_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label"
                                for="degree">{{ trans('studentactivities/questions.degree') }}</label>
                            <input type="number" id="degree" class="form-control" name="degree"
                                placeholder="5">
                            <span class="invalid-feedback" id="degree_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/questions.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentactivities/questions.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Question -->
<div class="modal fade" id="delete-question-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/questions.deleteQuestion') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/questions.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteQuestion') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="stage_id" name="stage_id" value="">
                    <div class="row">
                        <div class="col mt-2">
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/questions.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/questions.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Questions -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/questions.deleteSelectedQuestions') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/questions.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedQuestions') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/questions.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/questions.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

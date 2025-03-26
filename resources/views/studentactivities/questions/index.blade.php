@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <style>
        .custom-option-header {
            flex-direction: column;
        }
        .answer-text {
            width: 100%;
            overflow-wrap: anywhere; /* Ensures better line breaks */
        }

        .checked-error{
            border: 1px solid #ea5455 !important;
        }
    </style>
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.questions') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.schoolManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.questions') }}
@endsection

@section('content')
    @include('studentactivities.questions.modals')
@endsection

@section('js')
    {{-- Accordations Styling --}}
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script>
        $(document).ready(function() {
            const answersTextAr = document.querySelector('#answers_text_ar'), answersTextEn = document.querySelector('#answers_text_en');
            const tagifyanswersTextAr = new Tagify(answersTextAr, {maxTags: 5});
            const tagifyanswersTextEn = new Tagify(answersTextEn, {maxTags: 5});

            function updateCheckedClass() {
                $('.custom-option-content input[type="radio"]').each(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('.form-check').addClass('checked');
                    } else {
                        $(this).closest('.form-check').removeClass('checked');
                    }
                });
            }

            updateCheckedClass();

            $('.custom-option-content input[type="radio"]').on('change', function() {
                updateCheckedClass();
            });
        });

        $('#delete-selected-btn').on('click', function(e) {
            var selected = new Array();

            $(".card-body input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#delete-selected-modal').modal('show')
                $('input[id="ids"]').val(selected);
            }
        });
    </script>

    {{-- Add Question --}}
    <script>
        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['question_text_ar', 'question_text_en', 'is_correct_ar', 'is_correct_en', 'degree'];
            answers = ['answers_text_ar', 'answers_text_en'];

            $.each(answers, function(key, field) {
                $('#add-form #' + field).prev('.tagify').removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            $.each(fields, function(key, field) {
                $('#add-form #' + field).removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            var formData = $('#add-form')[0];
            var form = new FormData(formData);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: form,

                success: function(response) {
                    if (response.success) {
                        $.each(answers, function(key, field) {
                            $('#edit-form #' + field).val('');
                        });
                        $.each(fields, function(key, field) {
                            $('#edit-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#add-question-modal').modal('hide');
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);

                    if (response.error) {
                        toastr.error(response.error);
                        $('#add-question-modal').modal('hide');
                    } else if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            let element = $('#add-form #' + key.replace(/\.\d+\.value$/, ''));

                            if (key.includes('answers_text_ar') || key.includes(
                                    'answers_text_en')) {
                                element.prev('.tagify').addClass('is-invalid');
                            } else {
                                element.addClass('is-invalid');
                            }

                            $('#' + key.replace(/\.\d+\.value$/, '') + '_add_error').addClass(
                                'd-block').removeClass('d-none');
                            $('#' + key.replace(/\.\d+\.value$/, '') + '_add_error strong')
                                .text(
                                    val[0]);
                        });
                    }
                },

            });
        });
    </script>

    {{-- Change Answer --}}
    <script>
        $('[id^=change-answer-form-]').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            form.find('.is-invalid').removeClass('is-invalid');
            form.find('input[type="radio"]').closest('.form-check').removeClass('checked-error');
            form.find('.invalid-feedback').addClass('d-none').removeClass('d-block');

            var formData = new FormData(form[0]); // FormData instance including the CSRF token

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: formData,

                success: function(response) {
                    if(response.success) {
                        toastr.success(response.success)
                        location.reload(true)
                    }
                    else if(response.error){
                        toastr.error(response.error)
                    }
                },
                error: function(error) {
                    var response = error.responseJSON;

                    if(response.error) {
                        toastr.error(response.error)
                    }

                    $.each(response.errors, function(key, val) {
                        let keyClean = key.replace(/\.\d+$/, '');
                        let element = form.find('input[name="' + keyClean + '"]:checked');

                        if (element.length) {
                            let questionId = key.split('_')[1];
                            let errorElement = $('#customRadioTemp_' + questionId + '_error');

                            element.addClass('is-invalid');
                            element.closest('.form-check').addClass('checked-error');
                            errorElement.addClass('d-block').removeClass('d-none');
                            errorElement.find('strong').text(val[0]);
                        }
                    });
                },
            });
        });
    </script>

    {{-- Edit Question --}}
    <script>
        const answersTextArEdit = document.querySelector('#edit-question-modal #answers_text_ar'), answersTextEnEdit = document.querySelector('#edit-question-modal #answers_text_en');
        const tagifyAnswersTextArEdit = new Tagify(answersTextArEdit, { maxTags: 5 });
        const tagifyAnswersTextEnEdit = new Tagify(answersTextEnEdit, { maxTags: 5 });

        $('body').on('click', '#edit-question-button', function(e) {
            e.preventDefault();

            var modalId = 'edit-question-modal';

            var id = $(this).data('id')
            var question_text_ar = $(this).data('question_text_ar')
            var question_text_en = $(this).data('question_text_en')
            var answers = $(this).data('answers_text')
            var degree = $(this).data('degree')

            var answersAr = [];
            var answersEn = [];
            var correctAnswerAr = '';
            var correctAnswerEn = '';

            answers.forEach(answer => {
                answersAr.push({ value: answer.answer_text.ar, id: answer.id });
                answersEn.push({ value: answer.answer_text.en, id: answer.id });

                if (answer.is_correct) {
                    correctAnswerAr = answer.answer_text.ar;
                    correctAnswerEn = answer.answer_text.en;
                }
            });

            $('#' + modalId + ' #id').val(id);
            $('#' + modalId + ' #question_text_ar').val(question_text_ar);
            $('#' + modalId + ' #question_text_en').val(question_text_en);
            tagifyAnswersTextArEdit.removeAllTags();
            tagifyAnswersTextEnEdit.removeAllTags();
            tagifyAnswersTextArEdit.addTags(answersAr);
            tagifyAnswersTextEnEdit.addTags(answersEn);
            $('#' + modalId + ' #is_correct_ar').val(correctAnswerAr);
            $('#' + modalId + ' #is_correct_en').val(correctAnswerEn);
            $('#' + modalId + ' #degree').val(degree);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['question_text_ar', 'question_text_en', 'is_correct_ar', 'is_correct_en', 'degree'];
            answers = ['answers_text_ar', 'answers_text_en'];

            $.each(answers, function(key, field) {
                $('#edit-form #' + field).prev('.tagify').removeClass('is-invalid');
                $('#edit-form #' + field + '_edit_error').addClass('d-none').removeClass('d-block');
            });

            $.each(fields, function(key, field) {
                $('#edit-form #' + field).removeClass('is-invalid');
                $('#edit-form #' + field + '_edit_error').addClass('d-none').removeClass('d-block');
            });

            var formData = $('#edit-form')[0];
            var form = new FormData(formData);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: form,

                success: function(response) {
                    if (response.success) {
                        $.each(answers, function(key, field) {
                            $('#edit-form #' + field).val('');
                        });
                        $.each(fields, function(key, field) {
                            $('#edit-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#edit-question-modal').modal('hide');
                        location.reload(true);
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);

                    if (response.error) {
                        toastr.error(response.error);
                        $('#edit-question-modal').modal('hide');
                    } else if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            let element = $('#edit-form #' + key.replace(/\.\d+\.value$/, ''));

                            if (key.includes('answers_text_ar') || key.includes(
                                    'answers_text_en')) {
                                element.prev('.tagify').addClass('is-invalid');
                            } else {
                                element.addClass('is-invalid');
                            }

                            $('#' + key.replace(/\.\d+\.value$/, '') + '_edit_error').addClass(
                                'd-block').removeClass('d-none');
                            $('#' + key.replace(/\.\d+\.value$/, '') + '_edit_error strong')
                                .text(
                                    val[0]);
                        });
                    }
                },

            });
        });
    </script>

    {{-- Delete Question --}}
    <script>
        $('body').on('click', '#delete-question-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var question_text_ar = $(this).data('question_text_ar')
            var question_text_en = $(this).data('question_text_en')

            $('#delete-question-modal #id').val(id);
            $('#delete-question-modal #name').val(question_text_ar + '  -  ' + question_text_en);
        });

        $('#delete-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#delete-form')[0];
            var form = new FormData(formData);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: form,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        $('#delete-question-modal').modal('hide');
                        location.reload(true);
                    }
                }
            });
        });
    </script>

    {{-- Delete Seleted Questions --}}
    <script>
        $('#delete-selected-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#delete-selected-form')[0];
            var form = new FormData(formData);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: form,

                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success)
                        $('#delete-selected-modal').modal('hide')
                        location.reload(true);
                    }
                }
            });
        });
    </script>
@endsection

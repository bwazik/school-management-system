@extends('layouts.master')

@section('css')
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.settings') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.schoolManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.settings') }}
@endsection

@section('content')
    <div class="card">
        <form id="edit-form" action="{{ route('editSettings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ $settings->school_logo ? asset('assets/img/settings/' . $settings->school_logo) : asset('assets/img/settings/school.png') }}" alt="School Logo"
                        alt="school-logo" class="d-block w-px-100 h-px-100 rounded"
                        id="uploadedAvatar" />
                    <div class="button-wrapper">
                        <label for="school_logo" class="btn btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0">
                            <span class="d-none d-sm-block">{{ trans('settings/settings.upload') }}</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="school_logo" name="school_logo" class="account-file-input" hidden=""
                                accept=".png, .jpeg, .jpg" />
                        </label>
                        <button type="button" class="btn btn-label-secondary account-image-reset mb-3 waves-effect">
                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{ trans('settings/settings.reset') }}</span>
                        </button>
                        <div class="text-muted">{{ trans('settings/settings.upload_warning') }}</div>
                        <span class="invalid-feedback" id="school_logo_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="school_name_ar">{{ trans('settings/settings.school_name_ar') }}</label>
                        <input type="text" id="school_name_ar" class="form-control" name="school_name_ar"
                            value="{{ $settings->getTranslation('school_name', 'ar') }}"
                            placeholder="{{ $settings->getTranslation('school_name', 'ar') }}" />
                        <span class="invalid-feedback" id="school_name_ar_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="school_name_en">{{ trans('settings/settings.school_name_en') }}</label>
                        <input type="text" id="school_name_en" class="form-control" name="school_name_en"
                            value="{{ $settings->getTranslation('school_name', 'en') }}"
                            placeholder="{{ $settings->getTranslation('school_name', 'en') }}" />
                        <span class="invalid-feedback" id="school_name_en_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="school_title">{{ trans('settings/settings.school_title') }}</label>
                        <input type="text" id="school_title" class="form-control" name="school_title"
                            value="{{ $settings->school_title }}" placeholder="{{ $settings->school_title }}" />
                        <span class="invalid-feedback" id="school_title_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="school_phone">{{ trans('settings/settings.school_phone') }}</label>
                        <input type="number" id="school_phone" class="form-control" name="school_phone"
                            value="{{ $settings->school_phone }}" placeholder="{{ $settings->school_phone }}" />
                        <span class="invalid-feedback" id="school_phone_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="school_address_ar">{{ trans('settings/settings.school_address_ar') }}</label>
                        <input type="text" id="school_address_ar" class="form-control" name="school_address_ar"
                            value="{{ $settings->getTranslation('school_address', 'ar') }}"
                            placeholder="{{ $settings->getTranslation('school_address', 'ar') }}" />
                        <span class="invalid-feedback" id="school_address_ar_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="school_address_en">{{ trans('settings/settings.school_address_en') }}</label>
                        <input type="text" id="school_address_en" class="form-control" name="school_address_en"
                            value="{{ $settings->getTranslation('school_address', 'en') }}"
                            placeholder="{{ $settings->getTranslation('school_address', 'en') }}" />
                        <span class="invalid-feedback" id="school_address_en_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="school_email">{{ trans('settings/settings.school_email') }}</label>
                        <input type="email" id="school_email" class="form-control" name="school_email"
                            value="{{ $settings->school_email }}" placeholder="{{ $settings->school_email }}" />
                        <span class="invalid-feedback" id="school_email_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="default_language">{{ trans('settings/settings.default_language') }}</label>
                        <select id="default_language" name="default_language" class="select2Add form-select">
                            <option selected disabled value=""></option>
                            <option value="ar" {{ ($settings->default_language ?? '') === 'ar' ? 'selected' : '' }}>
                                Arabic</option>
                            <option value="en" {{ ($settings->default_language ?? '') === 'en' ? 'selected' : '' }}>
                                English</option>
                            <option value="fr" {{ ($settings->default_language ?? '') === 'fr' ? 'selected' : '' }}>
                                French</option>
                            <option value="de" {{ ($settings->default_language ?? '') === 'de' ? 'selected' : '' }}>
                                German</option>
                        </select>
                        <span class="invalid-feedback" id="default_language_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="max_students_per_class">{{ trans('settings/settings.max_students_per_class') }}</label>
                        <input type="number" id="max_students_per_class" class="form-control"
                            name="max_students_per_class" value="{{ $settings->max_students_per_class }}"
                            placeholder="{{ $settings->max_students_per_class }}" />
                        <span class="invalid-feedback" id="max_students_per_class_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="timezone">{{ trans('settings/settings.timezone') }}</label>
                        <select id="timezone" name="timezone" class="select2Add form-select">
                            @foreach ($timezones as $timezone)
                                <option value="{{ $timezone }}"
                                    {{ $settings->timezone === $timezone ? 'selected' : '' }}> {{ $timezone }}
                                </option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback" id="timezone_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="academic_year_start">{{ trans('settings/settings.academic_year_start') }}</label>
                        <input type="text" id="academic_year_start" class="form-control flatpickr-input"
                            name="academic_year_start" placeholder="YYYY-MM-DD" readonly="readonly"
                            value="{{ $settings->academic_year_start }}">
                        <span class="invalid-feedback" id="academic_year_start_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"
                            for="academic_year_end">{{ trans('settings/settings.academic_year_end') }}</label>
                        <input type="text" id="academic_year_end" class="form-control flatpickr-input"
                            name="academic_year_end" placeholder="YYYY-MM-DD" readonly="readonly"
                            value="{{ $settings->academic_year_end }}">
                        <span class="invalid-feedback" id="academic_year_end_error" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">{{ trans('settings/settings.submit') }}</button>
                    <button type="reset" class="btn btn-label-secondary waves-effect">{{ trans('settings/settings.cancel') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        // School Logo
        let accountUserImage = document.getElementById('uploadedAvatar');
        const fileInput = document.querySelector('.account-file-input'),
        resetFileInput = document.querySelector('.account-image-reset');

        if (accountUserImage) {
            const resetImage = accountUserImage.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                accountUserImage.src = resetImage;
            };
        }

        // Edit Settings
        $(document).ready(function() {
            var modalId = 'edit-form';
            var defaultLanguage = $('#edit-form #default_language').val();
            var timezone = $('#edit-form #timezone').val();

            initializeSelect2(modalId, 'default_language', defaultLanguage);
            initializeSelect2(modalId, 'timezone', timezone);

            $('#edit-form').on('submit', function(e) {
                e.preventDefault();

                fields = ['school_logo', 'school_name_ar ', 'school_name_en', 'school_title', 'school_phone', 'school_address_ar', 'school_address_en', 'school_email', 'default_language', 'max_students_per_class', 'timezone', 'max_students_per_class', 'academic_year_start', 'academic_year_end'];
                $.each(fields, function(key, field) {
                    $('#edit-form #' + field).removeClass('is-invalid');
                    $('#edit-form #' + field + '_error').addClass('d-none').removeClass('d-block');
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
                        if(response.success) {
                            toastr.success(response.success)
                            location.reload(true);
                        }
                    },
                    error: function(error) {
                        var response = $.parseJSON(error.responseText);
                        if (response.error) {
                            toastr.error(response.error);
                        } else if (response.errors) {
                            $.each(response.errors, function(key, val) {
                                $('#edit-form #' + key).addClass('is-invalid');
                                $('#edit-form #' + key + '_error').addClass('d-block').removeClass('d-none');
                                $('#edit-form #' + key + '_error strong').text(val[0]);
                            });
                        }
                    },
                });
            });
        });
    </script>
@endsection

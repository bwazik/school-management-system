@extends('layouts.master')

@section('css')
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.students') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.studentsManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.students') }}
@endsection

@section('content')
    @include('studentsmanagement.students.modals')
@endsection

@section('js')
    {{-- Show table data --}}
    <script>
        $(document).ready(function() {

            var language = '';
            @if (App::getLocale() == 'ar')
                var language = '{{ URL::asset('assets/json/datatable.json') }}';
            @endif

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('students') }}",
                language: {
                    url: language,
                },
                columns: [{
                        data: 'selectbox',
                        name: 'selectbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'stage_id',
                        name: 'stage_id'
                    },
                    {
                        data: 'grade_id',
                        name: 'grade_id'
                    },
                    {
                        data: 'classroom_id',
                        name: 'classroom_id'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: [{
                        extend: 'copy',
                        text: '<i class="ti ti-copy me-1"></i>Copy',
                        className: 'btn btn-secondary d-none'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="ti ti-file-text me-1"></i>CSV',
                        className: 'btn btn-secondary d-none'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                        className: 'btn btn-secondary d-none'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ti ti-file-description me-1"></i>PDF',
                        className: 'btn btn-secondary d-none'
                    },
                    {
                        extend: 'print',
                        text: '<i class="ti ti-printer me-1"></i>Print',
                        className: 'btn btn-secondary d-none'
                    }
                ]

            });

            table.on('init', function() {
                fields = ['print', 'csv', 'excel', 'pdf', 'copy'];
                $.each(fields, function(key, field) {
                    $('.' + field + '-button').on('click', function() {
                        table.button('.buttons-' + field).trigger();
                    });
                });
            });
        });
    </script>

    {{-- Show grades by stage in ajax --}}
    <script>
        $(document).ready(function() {
            $('#add-form #stage_id').on('change', function() {
                var stage = $(this).val();
                if (stage) {
                    $.ajax({
                        url: "{{ URL::to('classrooms/stages') }}/" + stage,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #grade_id').empty();
                            $('#add-form #grade_id').append(
                                '<option selected disabled value=""></option>'
                            );
                            $.each(data, function(key, value) {
                                $('#add-form #grade_id').append('<option value="' +
                                    key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

    {{-- Show classrooms by grade in ajax --}}
    <script>
        $(document).ready(function() {
            $('#add-form #grade_id').on('change', function() {
                var grade = $(this).val();
                if (grade) {
                    $.ajax({
                        url: "{{ URL::to('classrooms/grades') }}/" + grade,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #classroom_id').empty();
                            $('#add-form #classroom_id').append(
                                '<option selected disabled value=""></option>'
                            );
                            $.each(data, function(key, value) {
                                $('#add-form #classroom_id').append('<option value="' +
                                    key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

    {{-- Add Student --}}
    <script>
        $('body').on('click', '#add-student-button', function(e) {
            e.preventDefault();

            var modalId = 'add-student-modal';

            fields = ['gender_id', 'nationality', 'blood_type', 'religion', 'stage_id', 'grade_id', 'classroom_id',
                'parent_id', 'academic_year'
            ];

            $.each(fields, function(key, field) {
                initializeSelect2(modalId, field);
            });
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['email', 'password', 'name_ar', 'name_en', 'gender_id', 'nationality', 'blood_type',
                'religion', 'stage_id', 'grade_id', 'classroom_id', 'parent_id', 'birthday', 'academic_year',
                'attachment'
            ];
            $.each(fields, function(key, field) {
                $('#add-form #' + field).removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            var formData = $('#add-form')[0];
            var form = new FormData(formData);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                enctype: 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                data: form,

                success: function(response) {
                    if (response.success) {
                        $.each(fields, function(key, field) {
                            if ($('#add-form #' + field).is('select')) {
                                $('#add-form #' + field).val('').trigger(
                                    'change'); // Reset select elements
                            } else {
                                $('#add-form #' + field).val(''); // Reset input fields
                            }
                        });
                        toastr.success(response.success)
                        $('#add-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function(key, val) {
                        $('#add-form #' + key).addClass('is-invalid');
                        $('#add-form #' + key + '_add_error').addClass('d-block').removeClass(
                            'd-none');
                        $('#add-form #' + key + '_add_error strong').text(val[0]);
                    });
                },
            });
        });
    </script>

    {{-- Edit Student --}}
    <script>
        $('body').on('click', '#edit-student-button', function(e) {
            e.preventDefault();

            var modalId = 'edit-student-modal';

            var id = $(this).data('id')
            var email = $(this).data('email')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')
            var gender_id = $(this).data('gender_id')
            var nationality = $(this).data('nationality')
            var blood_type = $(this).data('blood_type')
            var religion = $(this).data('religion')
            var stage_id = $(this).data('stage_id')
            var grade_id = $(this).data('grade_id')
            var classroom_id = $(this).data('classroom_id')
            var parent_id = $(this).data('parent_id')
            var birthday = $(this).data('birthday')
            var academic_year = $(this).data('academic_year')

            $('#edit-student-modal #id').val(id);
            $('#edit-student-modal #email').val(email);
            $('#edit-student-modal #name_ar').val(name_ar);
            $('#edit-student-modal #name_en').val(name_en);
            initializeSelect2(modalId, 'gender_id', gender_id);
            initializeSelect2(modalId, 'nationality', nationality);
            initializeSelect2(modalId, 'blood_type', blood_type);
            initializeSelect2(modalId, 'religion', religion);
            initializeSelect2(modalId, 'stage_id', stage_id);
            initializeSelect2(modalId, 'grade_id', grade_id);
            initializeSelect2(modalId, 'classroom_id', classroom_id);
            initializeSelect2(modalId, 'parent_id', parent_id);
            $('#edit-student-modal #birthday').val(birthday);
            initializeSelect2(modalId, 'academic_year', academic_year);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['email', 'password', 'name_ar', 'name_en', 'gender_id', 'nationality', 'blood_type',
                'religion', 'stage_id', 'grade_id', 'classroom_id', 'parent_id', 'birthday', 'academic_year',
                'attachment'
            ];
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
                        $.each(fields, function(key, field) {
                            $('#edit-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#edit-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function(key, val) {
                        $('#edit-form #' + key).addClass('is-invalid');
                        $('#edit-form #' + key + '_edit_error').addClass('d-block').removeClass(
                            'd-none');
                        $('#edit-form #' + key + '_edit_error strong').text(val[0]);
                    });
                },
            });
        });
    </script>

    {{-- Delete Student --}}
    <script>
        $('body').on('click', '#delete-student-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#delete-student-modal #id').val(id);
            $('#delete-student-modal #name').val(name_ar + '  -  ' + name_en);
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
                        toastr.success(response.success)
                        $('#delete-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    } else {
                        toastr.error(response.error)
                        $('#delete-student-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Delete Seleted Students --}}
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
                        $('#datatable').DataTable().ajax.reload(null, false)
                    } else {
                        toastr.error(response.error)
                        $('#delete-selected-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Graduate Student --}}
    <script>
        $('body').on('click', '#graduate-student-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#graduate-student-modal #id').val(id);
            $('#graduate-student-modal #name').val(name_ar + '  -  ' + name_en);
        });

        $('#graduate-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#graduate-form')[0];
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
                        $('#graduate-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    } else {
                        toastr.error(response.error)
                        $('#graduate-student-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Graduate Seleted Students --}}
    <script>
        $('#graduate-selected-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#graduate-selected-form')[0];
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
                        $('#graduate-selected-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    } else {
                        toastr.error(response.error)
                        $('#graduate-selected-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Add Invoice --}}
    <script>
        $('body').on('click', '#add-invoice-button', function(e) {
            e.preventDefault();

            var modalId = 'add-invoice-modal';
            var id = $(this).data('id');
            var name = $(this).data('name');
            var fees = $(this).data('fees');

            if (typeof fees === 'string') {
                fees = fees.split(',').map(item => item.trim());
            }

            if (!Array.isArray(fees)) {
                fees = [fees];
            }

            $('#add-invoice-modal #id').val(id);
            $('#add-invoice-modal #name').val(name);

            var selectElement = $('#' + modalId + ' #fee');
            selectElement.empty();
            selectElement.append('<option selected disabled value=""></option>');

            @foreach ($fees as $fee)
                if (fees.includes("{{ $fee->id }}")) {
                    selectElement.append('<option value="{{ $fee->id }}">{{ $fee->name }}</option>');
                }
            @endforeach

            initializeSelect2(modalId, 'fee', fees);
        });

        $('#add-invoice-form #fee').on('change', function() {
            var fee = $(this).val();
            if (fee) {
                $.ajax({
                    url: "{{ URL::to('fees/amount') }}/" + fee,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#add-invoice-form #amount').empty();
                        $('#add-invoice-form #amount').val(data);
                    },
                });
            }
        });

        $('#add-invoice-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['fee', 'amount'];

            $.each(fields, function(key, field) {
                $('#add-invoice-form #' + field).removeClass('is-invalid');
                $('#add-invoice-form #' + field + '_error').addClass('d-none').removeClass('d-block');
            });

            var formData = $('#add-invoice-form')[0];
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
                        $.each(fields, function(key, field) {
                            $('#add-invoice-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#add-invoice-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function(key, val) {
                        $('#add-invoice-form #' + key).addClass('is-invalid');
                        $('#add-invoice-form #' + key + '_error').addClass('d-block')
                            .removeClass(
                                'd-none');
                        $('#add-invoice-form #' + key + '_error strong').text(val[0]);
                    });
                },
            });
        });
    </script>

    {{-- Add Receipt --}}
    <script>
        $('body').on('click', '#add-receipt-button', function(e) {
            e.preventDefault();

            var modalId = 'add-receipt-modal';
            var id = $(this).data('id');
            var name = $(this).data('name');
            var balance = $(this).data('balance');

            $('#add-receipt-modal #id').val(id);
            $('#add-receipt-modal #name').val(name);
            $('#add-receipt-modal #balance').val(balance);
        });

        $('#add-receipt-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['amount', 'balance', 'description'];

            $.each(fields, function(key, field) {
                $('#add-receipt-form #' + field).removeClass('is-invalid');
                $('#add-receipt-form #' + field + '_error').addClass('d-none').removeClass('d-block');
            });

            var formData = $('#add-receipt-form')[0];
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
                        $.each(fields, function(key, field) {
                            $('#add-receipt-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#add-receipt-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);

                    if (response.error) {
                        toastr.error(response.error);
                    }

                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $('#add-receipt-form #' + key).addClass('is-invalid');
                            $('#add-receipt-form #' + key + '_error').addClass('d-block')
                                .removeClass(
                                    'd-none');
                            $('#add-receipt-form #' + key + '_error strong').text(val[0]);
                        });
                    }
                },
            });
        });
    </script>

    {{-- Add Payment --}}
    <script>
        $('body').on('click', '#add-payment-button', function(e) {
            e.preventDefault();

            var modalId = 'add-payment-modal';
            var id = $(this).data('id');
            var name = $(this).data('name');
            var balance = $(this).data('balance');

            $('#add-payment-modal #id').val(id);
            $('#add-payment-modal #name').val(name);
            $('#add-payment-modal #balance').val(balance);
        });

        $('#add-payment-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['amount', 'balance', 'description'];

            $.each(fields, function(key, field) {
                $('#add-payment-form #' + field).removeClass('is-invalid');
                $('#add-payment-form #' + field + '_error').addClass('d-none').removeClass('d-block');
            });

            var formData = $('#add-payment-form')[0];
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
                        $.each(fields, function(key, field) {
                            $('#add-payment-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#add-payment-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);

                    if (response.error) {
                        toastr.error(response.error);
                    }

                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $('#add-payment-form #' + key).addClass('is-invalid');
                            $('#add-payment-form #' + key + '_error').addClass('d-block')
                                .removeClass(
                                    'd-none');
                            $('#add-payment-form #' + key + '_error strong').text(val[0]);
                        });
                    }
                },
            });
        });
    </script>

    {{-- Add Refund --}}
    <script>
        $('body').on('click', '#add-refund-button', function(e) {
            e.preventDefault();

            var modalId = 'add-refund-modal';
            var id = $(this).data('id');
            var name = $(this).data('name');
            var balance = $(this).data('balance');

            $('#add-refund-modal #id').val(id);
            $('#add-refund-modal #name').val(name);
            $('#add-refund-modal #balance').val(balance);
        });

        $('#add-refund-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['amount', 'balance', 'description'];

            $.each(fields, function(key, field) {
                $('#add-refund-form #' + field).removeClass('is-invalid');
                $('#add-refund-form #' + field + '_error').addClass('d-none').removeClass('d-block');
            });

            var formData = $('#add-refund-form')[0];
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
                        $.each(fields, function(key, field) {
                            $('#add-refund-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#add-refund-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);

                    if (response.error) {
                        toastr.error(response.error);
                    }

                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $('#add-refund-form #' + key).addClass('is-invalid');
                            $('#add-refund-form #' + key + '_error').addClass('d-block')
                                .removeClass(
                                    'd-none');
                            $('#add-refund-form #' + key + '_error strong').text(val[0]);
                        });
                    }
                },
            });
        });
    </script>

    {{-- Selected Checboxes --}}
    <script>
        $(function() {
            $('body').on('click', '#graduate-selected-btn', function(e) {
                var selected = new Array();

                $("#datatable input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#graduate-selected-modal').modal('show')
                    $('input[id="ids"]').val(selected);
                }
            });
        });
    </script>
@endsection

@extends('layouts.master')

@section('css')
    <style>
        .alert-danger {
            background-color: #fce4e4 !important;
            border-color: #fce4e4 !important;
            color: #ea5455 !important;
        }

        .alert-success {
            background-color: #ddf6e8 !important;
            border-color: #ddf6e8 !important;
            color: #28c76f !important;
        }
    </style>
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.promotions') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.studentsManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.promotions') }}
@endsection

@section('content')
    @include('studentsmanagement.promotions.modals')
@endsection

@section('js')
    {{-- Show table data --}}
    <script>
        $(document).ready(function() {

            var language = '';
            @if(App::getLocale() == 'ar')
                var language = '{{ URL::asset('assets/json/datatable.json') }}';
            @endif

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('promotions') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'student_id', name: 'student_id' },
                        { data: 'from_stage', name: 'from_stage' },
                        { data: 'from_grade', name: 'from_grade' },
                        { data: 'from_classroom', name: 'from_classroom' },
                        { data: 'from_academic_year', name: 'from_academic_year' },
                        { data: 'to_stage', name: 'to_stage' },
                        { data: 'to_grade', name: 'to_grade' },
                        { data: 'to_classroom', name: 'to_classroom' },
                        { data: 'to_academic_year', name: 'to_academic_year' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false},
                ],
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: [
                    {
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
                ],
                headerCallback: function(thead, data, start, end, display) {
                    // Add class to specific <th> elements
                    $(thead).find('th').each(function(index) {
                        if (index >= 3 && index <= 6) {
                            $(this).addClass('alert-danger');
                        } else if (index >= 7 && index <= 10) {
                            $(this).addClass('alert-success');
                        }
                    });
                }
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

    {{-- Show data by ajax --}}
    <script>
        $(document).ready(function() {
            $('#add-form #from_stage_id').on('change', function() {
                var stage = $(this).val();
                if (stage) {
                    $.ajax({
                        url: "{{ URL::to('classrooms/stages') }}/" + stage,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #from_grade_id').empty();
                            $('#add-form #from_grade_id').append(
                                '<option selected disabled value=""></option>'
                                );
                            $.each(data, function(key, value) {
                                $('#add-form #from_grade_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });

            $('#add-form #from_grade_id').on('change', function() {
                var grade = $(this).val();
                if (grade) {
                    $.ajax({
                        url: "{{ URL::to('classrooms/grades') }}/" + grade,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #from_classroom_id').empty();
                            $('#add-form #from_classroom_id').append(
                                '<option selected disabled value=""></option>'
                                );
                            $.each(data, function(key, value) {
                                $('#add-form #from_classroom_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });

            $('#add-form #to_stage_id').on('change', function() {
                var stage = $(this).val();
                if (stage) {
                    $.ajax({
                        url: "{{ URL::to('classrooms/stages') }}/" + stage,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #to_grade_id').empty();
                            $('#add-form #to_grade_id').append(
                                '<option selected disabled value=""></option>'
                                );
                            $.each(data, function(key, value) {
                                $('#add-form #to_grade_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });

            $('#add-form #to_grade_id').on('change', function() {
                var grade = $(this).val();
                if (grade) {
                    $.ajax({
                        url: "{{ URL::to('classrooms/grades') }}/" + grade,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #to_classroom_id').empty();
                            $('#add-form #to_classroom_id').append(
                                '<option selected disabled value=""></option>'
                                );
                            $.each(data, function(key, value) {
                                $('#add-form #to_classroom_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

    {{-- Add Promotion --}}
    <script>
        $('body').on('click', '#add-promotion-button', function(e) {
            e.preventDefault();

            var modalId = 'add-promotion-modal';

            fields = ['from_stage_id', 'from_grade_id', 'from_classroom_id', 'from_academic_year', 'to_stage_id', 'to_grade_id', 'to_classroom_id', 'to_academic_year'];

            $.each(fields, function(key, field) {
                initializeSelect2(modalId, field);
            });
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['from_stage_id', 'from_grade_id', 'from_classroom_id', 'from_academic_year', 'to_stage_id', 'to_grade_id', 'to_classroom_id', 'to_academic_year'];
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
                    if(response.success) {
                        $.each(fields, function(key, field) {
                            if ($('#add-form #' + field).is('select')) {
                                $('#add-form #' + field).val('').trigger('change'); // Reset select elements
                            } else {
                                $('#add-form #' + field).val(''); // Reset input fields
                            }
                        });
                        toastr.success(response.success)
                        $('#add-promotion-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    if (error.status === 404 || error.status === 405)
                    {
                        toastr.error(error.responseJSON.error);
                    }
                    else
                    {
                        var response = $.parseJSON(error.responseText);
                        $.each(response.errors, function(key, val) {
                            $('#add-form #' + key).addClass('is-invalid');
                            $('#add-form #' + key + '_add_error').addClass('d-block').removeClass('d-none');
                            $('#add-form #' + key + '_add_error strong').text(val[0]);
                        });
                    }
                },
            });
        });
    </script>

    {{-- Revert Student --}}
    <script>
        $('body').on('click', '#revert-student-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#revert-student-modal #id').val(id);
            $('#revert-student-modal #name').val(name_ar + '  -  ' + name_en);
        });

        $('#revert-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#revert-form')[0];
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
                        $('#revert-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#revert-student-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Revert Seleted Students --}}
    <script>
        $('#revert-selected-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#revert-selected-form')[0];
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
                        $('#revert-selected-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#revert-selected-modal').modal('hide')
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
                    if(response.success) {
                        toastr.success(response.success)
                        $('#graduate-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
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
                    if(response.success) {
                        toastr.success(response.success)
                        $('#graduate-selected-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#graduate-selected-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Selected Checboxes --}}
    <script>
        $(function() {
            $('body').on('click', '#revert-selected-btn', function(e) {
                var selected = new Array();

                $("#datatable input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#revert-selected-modal').modal('show')
                    $('input[id="ids"]').val(selected);
                }
            });
        });
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

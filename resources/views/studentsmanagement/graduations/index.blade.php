@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.graduations') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.studentsManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.graduations') }}
@endsection

@section('content')
    @include('studentsmanagement.graduations.modals')
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
                ajax: "{{ route('graduations') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'email', name: 'email' },
                        { data: 'name', name: 'name' },
                        { data: 'stage_id', name: 'stage_id' },
                        { data: 'grade_id', name: 'grade_id' },
                        { data: 'classroom_id', name: 'classroom_id' },
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
            $('#add-form #stage_id').on('change', function() {
                var stage = $(this).val();
                if (stage) {
                    $.ajax({
                        url: "{{ URL::to('admin/classrooms/stages') }}/" + stage,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #grade_id').empty();
                            $('#add-form #grade_id').append(
                                '<option selected disabled value=""></option>'
                                );
                            $.each(data, function(key, value) {
                                $('#add-form #grade_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });

            $('#add-form #grade_id').on('change', function() {
                var grade = $(this).val();
                if (grade) {
                    $.ajax({
                        url: "{{ URL::to('admin/classrooms/grades') }}/" + grade,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #classroom_id').empty();
                            $('#add-form #classroom_id').append(
                                '<option selected disabled value=""></option>'
                                );
                            $.each(data, function(key, value) {
                                $('#add-form #classroom_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

    {{-- Add Graduation --}}
    <script>
        $('body').on('click', '#add-graduation-button', function(e) {
            e.preventDefault();

            var modalId = 'add-graduation-modal';

            fields = ['stage_id', 'grade_id', 'classroom_id', 'academic_year'];

            $.each(fields, function(key, field) {
                initializeSelect2(modalId, field);
            });
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['stage_id', 'grade_id', 'classroom_id', 'academic_year'];
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
                        $('#add-graduation-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    if (error.status === 404)
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

    {{-- Return Student --}}
    <script>
        $('body').on('click', '#return-student-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#return-student-modal #id').val(id);
            $('#return-student-modal #name').val(name_ar + '  -  ' + name_en);
        });

        $('#return-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#return-form')[0];
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
                        $('#return-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#return-student-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Return Seleted Students --}}
    <script>
        $('#return-selected-form').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#return-selected-form')[0];
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
                        $('#return-selected-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#return-selected-modal').modal('hide')
                    }
                }
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
                    if(response.success) {
                        toastr.success(response.success)
                        $('#delete-student-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
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
                    if(response.success) {
                        toastr.success(response.success)
                        $('#delete-selected-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-selected-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Selected Checboxes --}}
    <script>
        $(function() {
            $('body').on('click', '#return-selected-btn', function(e) {
                var selected = new Array();

                $("#datatable input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#return-selected-modal').modal('show')
                    $('input[id="ids"]').val(selected);
                }
            });
        });
    </script>
@endsection

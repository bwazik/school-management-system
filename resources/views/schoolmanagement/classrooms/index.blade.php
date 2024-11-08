@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.classrooms') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.schoolManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.classrooms') }}
@endsection

@section('content')
    @include('schoolmanagement.classrooms.modals')
@endsection

@section('js')
    {{-- Show table data --}}
    <script>
        $(document).ready(function() {
            $('.accordion-button').on('click', function() {
                var language = '';
                @if(App::getLocale() == 'ar')
                    var language = '{{ URL::asset('assets/json/datatable.json') }}';
                @endif

                var stageId = $(this).data('bs-target').split('-')[1];
                var tableId = '#datatable-' + stageId;
                var url = $(this).data('url');

                if (!$.fn.DataTable.isDataTable(tableId)) {
                    var table = $(tableId).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: url,
                            type: 'GET'
                        },
                        language: {
                            url: language,
                        },
                        columns: [
                                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                                { data: 'name', name: 'name' },
                                { data: 'grade_id', name: 'grade_id' },
                                { data: 'status', name: 'status' },
                                { data: 'created_at', name: 'created_at' },
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

                    $(this).data('datatable', table);

                }
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
                                $('#add-form #grade_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

    {{-- Add Classroom --}}
    <script>
        $('body').on('click', '#add-classroom-button', function(e) {
            e.preventDefault();

            var modalId = 'add-classroom-modal';

            initializeSelect2(modalId, 'stage_id');
            initializeSelect2(modalId, 'grade_id');
            initializeSelect2(modalId, 'teachers');
            initializeSelect2(modalId, 'status');
        });

        $('#add-form').on('submit', function(e, stageId) {
            e.preventDefault();

            fields = ['name_ar', 'name_en', 'stage_id', 'grade_id', 'teachers', 'status'];
            $.each(fields, function(key, field) {
                $('#add-form #' + field).removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            var stageId = $('#add-form #stage_id').val();
            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#add-classroom-modal"));

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
                        myOffcanvas.hide();
                        if ($.fn.dataTable.isDataTable('#datatable-' + stageId)) {
                            $('#datatable-' + stageId).DataTable().ajax.reload(null, false)
                        }
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function(key, val) {
                        $('#add-form #' + key).addClass('is-invalid');
                        $('#add-form #' + key + '_add_error').addClass('d-block').removeClass('d-none');
                        $('#add-form #' + key + '_add_error strong').text(val[0]);
                    });
                },
            });
        });
    </script>

    {{-- Edit Classroom --}}
    <script>
        $('body').on('click', '#edit-classroom-button', function(e) {
            e.preventDefault();

            var modalId = 'edit-classroom-modal';

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')
            var stage_id = $(this).data('stage_id')
            var grade_id = $(this).data('grade_id')
            var teachers = $(this).data('teachers');
            var status = $(this).data('status')

            if (typeof teachers === 'string') {
                teachers = teachers.split(',');
            }
            
            $('#edit-classroom-modal #id').val(id);
            $('#edit-classroom-modal #name_ar').val(name_ar);
            $('#edit-classroom-modal #name_en').val(name_en);
            initializeSelect2(modalId, 'stage_id', stage_id);
            initializeSelect2(modalId, 'grade_id', grade_id);
            initializeSelect2(modalId, 'teachers', teachers);
            initializeSelect2(modalId, 'status', status);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['name_ar', 'name_en', 'stage_id', 'grade_id', 'teachers', 'status'];
            $.each(fields, function(key, field) {
                $('#edit-form #' + field).removeClass('is-invalid');
                $('#edit-form #' + field + '_edit_error').addClass('d-none').removeClass('d-block');
            });

            var stageId = $('#edit-form #stage_id').val();
            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#edit-classroom-modal"));

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
                        $.each(fields, function(key, field) {
                            if ($('#edit-form #' + field).is('select')) {
                                $('#edit-form #' + field).val('').trigger('change'); // Reset select elements
                            } else {
                                $('#edit-form #' + field).val(''); // Reset input fields
                            }
                        });
                        toastr.success(response.success)
                        myOffcanvas.hide()
                        if ($.fn.dataTable.isDataTable('#datatable-' + stageId)) {
                            $('#datatable-' + stageId).DataTable().ajax.reload(null, false)
                        }
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function(key, val) {
                        $('#edit-form #' + key).addClass('is-invalid');
                        $('#edit-form #' + key + '_edit_error').addClass('d-block').removeClass('d-none');
                        $('#edit-form #' + key + '_edit_error strong').text(val[0]);
                    });
                },
            });
        });
    </script>

    {{-- Delete Classroom --}}
    <script>
        $('body').on('click', '#delete-classroom-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')
            var stage_id = $(this).data('stage_id')

            $('#delete-classroom-modal #id').val(id);
            $('#delete-classroom-modal #name').val(name_ar + '  -  ' + name_en);
            $('#delete-classroom-modal #stage_id').val(stage_id);
        });

        $('#delete-form').on('submit', function(e) {
            e.preventDefault();

            var stageId = $('#delete-form #stage_id').val();

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
                        $('#delete-classroom-modal').modal('hide')
                        if ($.fn.dataTable.isDataTable('#datatable-' + stageId)) {
                            $('#datatable-' + stageId).DataTable().ajax.reload(null, false)
                        }
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-classroom-modal').modal('hide')
                    }
                }
            });
        });
    </script>
@endsection

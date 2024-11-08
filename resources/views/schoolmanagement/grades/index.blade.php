@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.grades') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.schoolManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.grades') }}
@endsection

@section('content')
    @include('schoolmanagement.grades.modals')
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
                ajax: "{{ route('grades') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name', name: 'name' },
                        { data: 'stage_id', name: 'stage_id' },
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
        });
    </script>

    {{-- Add Grade --}}
    <script>
        $('body').on('click', '#add-grade-button', function(e) {
            e.preventDefault();

            var modalId = 'add-grade-modal';

            initializeSelect2(modalId, 'stage_id');
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['name_ar', 'name_en', 'stage_id'];
            $.each(fields, function(key, field) {
                $('#add-form #' + field).removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#add-grade-modal"));

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
                        $('#datatable').DataTable().ajax.reload(null, false)
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

    {{-- Edit Grade --}}
    <script>
        $('body').on('click', '#edit-grade-button', function(e) {
            e.preventDefault();

            var modalId = 'edit-grade-modal';

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')
            var stage_id = $(this).data('stage_id')

            $('#edit-grade-modal #id').val(id);
            $('#edit-grade-modal #name_ar').val(name_ar);
            $('#edit-grade-modal #name_en').val(name_en);

            initializeSelect2(modalId, 'stage_id', stage_id);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['name_ar', 'name_en', 'stage_id'];
            $.each(fields, function(key, field) {
                $('#edit-form #' + field).removeClass('is-invalid');
                $('#edit-form #' + field + '_edit_error').addClass('d-none').removeClass('d-block');
            });

            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#edit-grade-modal"));

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
                            $('#edit-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        myOffcanvas.hide()
                        $('#datatable').DataTable().ajax.reload(null, false)
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

    {{-- Delete Grade --}}
    <script>
        $('body').on('click', '#delete-grade-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#delete-grade-modal #id').val(id);
            $('#delete-grade-modal #name').val(name_ar + '  -  ' + name_en);
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
                        $('#delete-grade-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-grade-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Delete Seleted Grades --}}
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

    {{-- Filter By Stage --}}
    <script>
        var language = '';
        @if(App::getLocale() == 'ar')
            var language = '{{ URL::asset('assets/json/datatable.json') }}';
        @endif

        $('.dropdown-item-filter').on('click', function(e) {
            e.preventDefault();

            var stageId = $(this).data('id');
            var form = document.getElementById('form-' + stageId);

            if (form) {
                var id = form.querySelector("#stage_id").value;

                var table = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy : true,
                    language: {
                            url: language,
                        },
                    ajax: {
                            url: form.action,
                            type: form.method,
                            data: {
                                _token: "{{ csrf_token() }}",
                                "id": id,
                            },
                            error: function(error) {
                                console.log(error);
                            },
                        },
                    columns: [
                            { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                            { data: 'name', name: 'name' },
                            { data: 'stage_id', name: 'stage_id' },
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
            }

        });
    </script>
@endsection

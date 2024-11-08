@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.subjects') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.schoolManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.subjects') }}
@endsection

@section('content')
    @include('schoolmanagement.subjects.modals')
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
                ajax: "{{ route('subjects') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name', name: 'name' },
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

    {{-- Add Subject --}}
    <script>
        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['name_ar', 'name_en'];
            $.each(fields, function(key, field) {
                $('#add-form #' + field).removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#add-subject-modal"));

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
                            $('#add-form #' + field).val('');
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

    {{-- Edit Subject --}}
    <script>
        $('body').on('click', '#edit-subject-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#edit-subject-modal #id').val(id);
            $('#edit-subject-modal #name_ar').val(name_ar);
            $('#edit-subject-modal #name_en').val(name_en);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['name_ar', 'name_en'];
            $.each(fields, function(key, field) {
                $('#edit-form #' + field).removeClass('is-invalid');
                $('#edit-form #' + field + '_edit_error').addClass('d-none').removeClass('d-block');
            });

            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#edit-subject-modal"));

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

    {{-- Delete Subject --}}
    <script>
        $('body').on('click', '#delete-subject-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#delete-subject-modal #id').val(id);
            $('#delete-subject-modal #name').val(name_ar + '  -  ' + name_en);
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
                        $('#delete-subject-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-subject-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Delete Seleted Subjects --}}
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
@endsection

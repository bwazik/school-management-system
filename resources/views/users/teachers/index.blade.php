@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.teachers') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.users') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.teachers') }}
@endsection

@section('content')
    @include('users.teachers.modals')
@endsection

@section('js')
    {{-- Show table data --}}
    <script>
        $(document).ready(function() {

            var language = '';
            @if(App::getLocale() == 'ar')
                var language = '{{ asset('assets/json/datatable.json') }}';
            @endif

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('teachers') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'email', name: 'email' },
                        { data: 'name', name: 'name' },
                        { data: 'subject_id', name: 'subject_id' },
                        { data: 'joining_date', name: 'joining_date' },
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

    {{-- Add Teacher --}}
    <script>
        $('body').on('click', '#add-teacher-button', function(e) {
            e.preventDefault();

            var modalId = 'add-teacher-modal';

            initializeSelect2(modalId, 'subject_id');
            initializeSelect2(modalId, 'gender_id');
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['email', 'password', 'name_ar', 'name_en', 'subject_id', 'gender_id', 'joining_date', 'attachment', 'address'];
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
                    if(response.success) {
                        $.each(fields, function(key, field) {
                            if ($('#add-form #' + field).is('select')) {
                                $('#add-form #' + field).val('').trigger('change'); // Reset select elements
                            } else {
                                $('#add-form #' + field).val(''); // Reset input fields
                            }
                        });
                        toastr.success(response.success)
                        $('#add-teacher-modal').modal('hide')
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

    {{-- Edit Teacher --}}
    <script>
        $('body').on('click', '#edit-teacher-button', function(e) {
            e.preventDefault();

            var modalId = 'edit-teacher-modal';

            var id = $(this).data('id')
            var email = $(this).data('email')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')
            var subject_id = $(this).data('subject_id')
            var gender_id = $(this).data('gender_id')
            var joining_date = $(this).data('joining_date')
            var address = $(this).data('address')

            $('#edit-teacher-modal #id').val(id);
            $('#edit-teacher-modal #email').val(email);
            $('#edit-teacher-modal #name_ar').val(name_ar);
            $('#edit-teacher-modal #name_en').val(name_en);
            initializeSelect2(modalId, 'subject_id', subject_id);
            initializeSelect2(modalId, 'gender_id', gender_id);
            $('#edit-teacher-modal #joining_date').val(joining_date);
            $('#edit-teacher-modal #address').val(address);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['email', 'password', 'name_ar', 'name_en', 'subject_id', 'gender_id', 'joining_date', 'address'];
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
                    if(response.success) {
                        $.each(fields, function(key, field) {
                            $('#edit-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#edit-teacher-modal').modal('hide')
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

    {{-- Delete Teacher --}}
    <script>
        $('body').on('click', '#delete-teacher-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var name_ar = $(this).data('name_ar')
            var name_en = $(this).data('name_en')

            $('#delete-teacher-modal #id').val(id);
            $('#delete-teacher-modal #name').val(name_ar + '  -  ' + name_en);
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
                        $('#delete-teacher-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-teacher-modal').modal('hide')
                    }
                }
            });
        });
    </script>

    {{-- Delete Seleted Teachers --}}
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

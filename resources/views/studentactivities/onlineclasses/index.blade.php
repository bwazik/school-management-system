@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.onlineClasses') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.schoolManagement') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.onlineClasses') }}
@endsection

@section('content')
    @include('studentactivities.onlineclasses.modals')
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
                ajax: "{{ route('onlineClasses') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'topic', name: 'topic' },
                        { data: 'teacher_id', name: 'teacher_id' },
                        { data: 'duration', name: 'duration' },
                        { data: 'start_time', name: 'start_time' },
                        { data: 'join_url', name: 'join_url' },
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

    {{-- Show grades by stage in ajax --}}
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
        });
    </script>

    {{-- Show classrooms by grade in ajax --}}
    <script>
        $(document).ready(function() {
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

    {{-- Show teachers by classroom in ajax --}}
    <script>
        $(document).ready(function() {
            $('#add-form #classroom_id').on('change', function() {
                var classroom = $(this).val();
                if (classroom) {
                    $.ajax({
                        url: "{{ URL::to('admin/classrooms/teachers') }}/" + classroom,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #teacher_id').empty();
                            $('#add-form #teacher_id').append(
                                '<option selected disabled value=""></option>'
                            );
                            $.each(data, function(key, value) {
                                $('#add-form #teacher_id').append('<option value="' +
                                    key + '">' +
                                    value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

    {{-- Add Online Class --}}
    <script>
        $('body').on('click', '#add-online-class-button', function(e) {
            e.preventDefault();

            var modalId = 'add-online-class-modal';

            initializeSelect2(modalId, 'stage_id');
            initializeSelect2(modalId, 'grade_id');
            initializeSelect2(modalId, 'classroom_id');
            initializeSelect2(modalId, 'teacher_id');
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['stage_id ', 'grade_id', 'classroom_id', 'teacher_id', 'topic_ar', 'topic_en', 'duration', 'start_time', 'password'];
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
                            $('#add-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        $('#add-online-class-modal').modal('hide');
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);

                    if (response.error) {
                        toastr.error(response.error);
                        $('#add-question-modal').modal('hide');
                    } else if (response.errors) {
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

    {{-- Edit Online Class --}}
    <script>
        $('body').on('click', '#edit-online-class-button', function(e) {
            e.preventDefault();

            var modalId = 'edit-online-class-modal';

            var id = $(this).data('id')
            var meeting_id = $(this).data('meeting_id')
            var stage_id = $(this).data('stage_id')
            var grade_id = $(this).data('grade_id')
            var classroom_id = $(this).data('classroom_id')
            var teacher_id = $(this).data('teacher_id')
            var topic_ar = $(this).data('topic_ar')
            var topic_en = $(this).data('topic_en')
            var duration = $(this).data('duration')
            var start_time = $(this).data('start_time')

            $('#edit-online-class-modal #id').val(id);
            $('#edit-online-class-modal #meeting_id').val(meeting_id);
            initializeSelect2(modalId, 'stage_id', stage_id);
            initializeSelect2(modalId, 'grade_id', grade_id);
            initializeSelect2(modalId, 'classroom_id', classroom_id);
            initializeSelect2(modalId, 'teacher_id', teacher_id);
            $('#edit-online-class-modal #topic_ar').val(topic_ar);
            $('#edit-online-class-modal #topic_en').val(topic_en);
            $('#edit-online-class-modal #duration').val(duration);
            $('#edit-online-class-modal #start_time').val(start_time);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['stage_id ', 'grade_id', 'classroom_id', 'teacher_id', 'topic_ar', 'topic_en', 'duration', 'start_time', 'password'];
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
                        $('#edit-online-class-modal').modal('hide');
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);
                    if (response.error) {
                        toastr.error(response.error);
                        $('#add-question-modal').modal('hide');
                    } else if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $('#edit-form #' + key).addClass('is-invalid');
                            $('#edit-form #' + key + '_edit_error').addClass('d-block').removeClass('d-none');
                            $('#edit-form #' + key + '_edit_error strong').text(val[0]);
                        });
                    }
                },
            });
        });
    </script>

    {{-- Delete Online Class --}}
    <script>
        $('body').on('click', '#delete-online-class-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var meeting_id = $(this).data('meeting_id')
            var topic_ar = $(this).data('topic_ar')
            var topic_en = $(this).data('topic_en')

            $('#delete-online-class-modal #id').val(id);
            $('#delete-online-class-modal #meeting_id').val(meeting_id);
            $('#delete-online-class-modal #topic').val(topic_ar + '  -  ' + topic_en);
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
                        $('#delete-online-class-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-online-class-modal').modal('hide')
                    }
                },
                error: function(error) {
                    if (response.error) {
                        toastr.error(response.error);
                        $('#delete-question-modal').modal('hide');
                    }
                },
            });
        });
    </script>

    {{-- Delete Seleted Online Classes --}}
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
                },
                error: function(error) {
                    if (response.error) {
                        toastr.error(response.error);
                        $('#delete-question-modal').modal('hide');
                    }
                },
            });
        });
    </script>
@endsection

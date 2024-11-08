@extends('layouts.master')

@section('css')
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.attendances') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.studentActivities') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.attendances') }} - ({{ date('Y-m-d') }})
@endsection

@section('content')
    @include('studentactivities.attendances.table')
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
                url: "{{ route('getStudentsWithAttendances', $classroomId) }}",
                language: {
                    url: language,
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
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

    {{-- Add Attendance --}}
    <script>
        $('#add-attendance-btn').on('click', function(e) {
            e.preventDefault();

            var formData = $('#attendance-form')[0];
            var form = new FormData(formData);

            $.ajax({
                url: $('#attendance-form').attr('action'),
                type: $('#attendance-form').attr('method'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: form,

                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success)
                        $('#attendance-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                        formData.reset();
                    }else if (response.done) {
                        $('#attendance-modal').modal('hide')
                        toastr.error(response.done);
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);
                    if (response.error) {
                        toastr.error(response.error);
                    } else if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            toastr.error(val[0]);
                        });
                    }
                },

            });
        });
    </script>
@endsection

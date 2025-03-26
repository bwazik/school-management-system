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
    {{ trans('layouts/sidebar.attendances') }}
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div class="card-body">
                <div class="accordion mt-3" id="accordionExample">
                    @foreach ($stagesWithClassrooms as $stage)
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-url="{{ route('getAllClassroomsAttendance', $stage -> id) }}"
                                    data-bs-target="#accordion-{{ $stage -> id }}" aria-expanded="false" aria-controls="accordion-{{ $stage -> id }}">
                                    {{ $stage -> name }}
                                </button>
                            </h2>
                            <div id="accordion-{{ $stage -> id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                                style="">
                                <div class="accordion-body">
                                    <table id="datatable-{{ $stage -> id }}" data-stage-id={{ $stage -> id }} class="datatables-basic table" style="white-space: nowrap;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans('studentactivities/attendances.name') }}</th>
                                                <th>{{ trans('studentactivities/attendances.grade') }}</th>
                                                <th>{{ trans('studentactivities/attendances.status') }}</th>
                                                <th>{{ trans('studentactivities/attendances.students') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- Show table data --}}
    <script>
        $(document).ready(function() {
            $('.accordion-button').on('click', function() {
                var language = '';
                @if(App::getLocale() == 'ar')
                    var language = '{{ asset('assets/json/datatable.json') }}';
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
@endsection

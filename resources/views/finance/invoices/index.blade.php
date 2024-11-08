@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.invoices') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.finance') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.invoices') }}
@endsection

@section('content')
    @include('finance.invoices.modals')
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
                ajax: "{{ route('invoices') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'fee_id', name: 'fee_id' },
                        { data: 'amount', name: 'amount' },
                        { data: 'date', name: 'date' },
                        { data: 'student_id', name: 'student_id' },
                        { data: 'stage_id', name: 'stage_id' },
                        { data: 'grade_id', name: 'grade_id' },
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

    {{-- Show student details in ajax --}}
    <script>
        $(document).ready(function() {
            $('#add-form #student_id').on('change', function() {
                var student = $(this).val();
                if (student) {
                    $.ajax({
                        url: "{{ URL::to('invoices/student') }}/" + student,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #stage_id').empty().val('');
                            $('#add-form #grade_id').empty().val('');
                            $('#add-form #fees').empty().append('<option selected disabled value=""></option>');

                            if (data.stage_id && data.grade_id) {
                                $('#add-form #stage_id').val(data.stage_id);
                                $('#add-form #grade_id').val(data.grade_id);
                                $('#add-form #stage').val(data.stage);
                                $('#add-form #grade').val(data.grade);
                            }

                            $.each(data.fees, function(key, value) {
                                $('#add-form #fees').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                        error: function() {
                            toastr.error('Error fetching student details.');
                        }
                    });
                }
            });

            $('#add-form #fees').on('change', function() {
                var fee = $(this).val();
                if (fee) {
                    $.ajax({
                        url: "{{ URL::to('fees/amount') }}/" + fee,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #amount').empty();
                            $('#add-form #amount').val(data);
                        },
                        error: function() {
                            toastr.error('Error fetching fee amount.');
                        }
                    });
                }
            });
        });
    </script>

    {{-- Add Invoice --}}
    <script>
        $('body').on('click', '#add-invoice-button', function(e) {
            e.preventDefault();

            var modalId = 'add-invoice-modal';

            initializeSelect2(modalId, 'student_id');
            initializeSelect2(modalId, 'fees');
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['student_id', 'stage', 'stage_id', 'grade', 'grade_id', 'fees', 'amount'];
            $.each(fields, function(key, field) {
                $('#add-form #' + field).removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#add-invoice-modal"));

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

    {{-- Delete Invoice --}}
    <script>
        $('body').on('click', '#delete-invoice-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var fee = $(this).data('fee')
            var amount = $(this).data('amount')
            var student = $(this).data('student')

            $('#delete-invoice-modal #id').val(id);
            $('#delete-invoice-modal #name').val(student + '  -  ' + fee + '  -  ' + amount + '$');
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
                        $('#delete-invoice-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-invoice-modal').modal('hide')
                    }
                }
            });
        });
    </script>
@endsection

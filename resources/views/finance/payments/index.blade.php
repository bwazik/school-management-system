@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.payments') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.finance') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.payments') }}
@endsection

@section('content')
    @include('finance.payments.modals')
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
                ajax: "{{ route('payments') }}",
                language: {
                        url: language,
                    },
                columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'student_id', name: 'student_id' },
                        { data: 'credit', name: 'credit' },
                        { data: 'date', name: 'date' },
                        { data: 'description', name: 'description' },
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

    {{-- Show student balance in ajax --}}
    <script>
        $(document).ready(function() {
            $('#add-form #student_id').on('change', function() {
                var student = $(this).val();
                if (student) {
                    $.ajax({
                        url: "{{ URL::to('admin/refunds/student') }}/" + student,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#add-form #balance').empty().val(data.balance);
                        },
                        error: function() {
                            toastr.error('Error fetching student details.');
                        }
                    });
                }
            });
        });
    </script>

    {{-- Add Payment --}}
    <script>
        $('body').on('click', '#add-payment-button', function(e) {
            e.preventDefault();

            var modalId = 'add-payment-modal';

            initializeSelect2(modalId, 'student_id');
        });

        $('#add-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['student_id', 'amount', 'balance', 'description'];
            $.each(fields, function(key, field) {
                $('#add-form #' + field).removeClass('is-invalid');
                $('#add-form #' + field + '_add_error').addClass('d-none').removeClass('d-block');
            });

            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#add-payment-modal"));

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

                    if (response.error) {
                        toastr.error(response.error);
                    }

                    if (response.errors) {
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

    {{-- Edit Payment --}}
    <script>
        $('body').on('click', '#edit-payment-button', function(e) {
            e.preventDefault();

            var modalId = 'edit-payment-modal';

            var id = $(this).data('id')
            var student_id = $(this).data('student_id')
            var amount = $(this).data('amount')
            var balance = $(this).data('balance')
            var description = $(this).data('description')

            $('#edit-payment-modal #id').val(id);
            $('#edit-payment-modal #student_id').val(student_id);
            $('#edit-payment-modal #amount').val(amount);
            $('#edit-payment-modal #balance').val(balance);
            $('#edit-payment-modal #description').val(description);
        });

        $('#edit-form').on('submit', function(e) {
            e.preventDefault();

            fields = ['student_id', 'amount', 'balance', 'description'];

            $.each(fields, function(key, field) {
                $('#edit-form #' + field).removeClass('is-invalid');
                $('#edit-form #' + field + '_edit_error').addClass('d-none').removeClass('d-block');
            });

            var myOffcanvas = bootstrap.Offcanvas.getInstance(document.querySelector("#edit-payment-modal"));

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
                    if (response.success) {
                        $.each(fields, function(key, field) {
                            $('#edit-form #' + field).val('');
                        });
                        toastr.success(response.success)
                        myOffcanvas.hide();
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                },
                error: function(error) {
                    var response = $.parseJSON(error.responseText);

                    if (response.error) {
                        toastr.error(response.error);
                    }

                    if (response.errors) {
                        var response = $.parseJSON(error.responseText);
                        $.each(response.errors, function(key, val) {
                            $('#edit-form #' + key).addClass('is-invalid');
                            $('#edit-form #' + key + '_edit_error').addClass('d-block').removeClass(
                                'd-none');
                            $('#edit-form #' + key + '_edit_error strong').text(val[0]);
                        });
                    }
                },
            });
        });
    </script>

    {{-- Delete Payment --}}
    <script>
        $('body').on('click', '#delete-payment-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var amount = $(this).data('amount')
            var student = $(this).data('student')

            $('#delete-payment-modal #id').val(id);
            $('#delete-payment-modal #name').val(student + '  -  ' + amount + '$');
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
                        $('#delete-payment-modal').modal('hide')
                        $('#datatable').DataTable().ajax.reload(null, false)
                    }
                    else
                    {
                        toastr.error(response.error)
                        $('#delete-payment-modal').modal('hide')
                    }
                },
                error: function(error) {
                    if (response.error) {
                        toastr.error(response.error);
                    }
                },
            });
        });
    </script>
@endsection

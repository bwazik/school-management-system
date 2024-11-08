@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    @livewireStyles
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.parents') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.users') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.parents') }}
@endsection

@section('content')
    <div class="row">
        <livewire:users.parents />
    </div>
@endsection

@section('js')
    @livewireScripts

    <script>
        $(document).ready(function() {

            var language = '';
            @if(App::getLocale() == 'ar')
                var language = '{{ URL::asset('assets/json/datatable.json') }}';
            @endif

            var table = $('#datatable').DataTable({
                language: {
                    url: language,
                },
                columnDefs: [
                    { orderable: false, searchable: false, targets: [0, 2, 7] }
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

        $('body').on('click', '#delete-parent-button', function(e) {
            e.preventDefault();

            var id = $(this).data('id')
            var email = $(this).data('email')

            $('#delete-parent-modal #id').val(id);
            $('#delete-parent-modal #name').val(email);
        });

        @if (Session::has('deleted'))
            toastr.success('{{ Session::get('deleted') }}');
        @endif
        @if (Session::has('deletedSelected'))
            toastr.success('{{ Session::get('deletedSelected') }}');
        @endif
    </script>
@endsection

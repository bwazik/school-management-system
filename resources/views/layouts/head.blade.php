<!-- Title -->
<title>@yield("pageTitle")</title>

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon/favicon.png') }}" />
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
@if(App::getLocale() == 'en')
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
@else
    <link href="https://fonts.googleapis.com/css2?family=Cairo:slnt,wght@-11..11,200..1000&display=swap" rel="stylesheet">
@endif

<!-- Icons -->
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/fonts/tabler-icons.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/fonts/flag-icons.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

<!-- Core CSS -->
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ URL::asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/toastr/toastr.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />

<!--- Page css -->
@yield('css')

<!-- Helpers -->
<script src="{{ URL::asset('assets/vendor/js/helpers.js') }}"></script>

<script src="{{ URL::asset('assets/js/config.js') }}"></script>

<style>
    #datatable{
        text-align: center !important;
        width: 100% !important;
    }

    #datatable th{
        text-align: center !important;
    }

    .error-border-color{
        border-color: #ea5455;
    }

        /* Hide arrows in WebKit browsers (Chrome, Safari) */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide arrows in Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Hide arrows in other browsers */
    input[type="number"] {
        appearance: textfield;
    }

    textarea {
        resize: none;
    }

    input[readonly] {
        background-color: rgba(75, 70, 92, 0.08) !important;
    }

    .input-group input[readonly] + .input-group-text {
    background-color: rgba(75, 70, 92, 0.08) !important;
    }

    .input-group input[disabled] + .input-group-text {
    background-color: rgba(75, 70, 92, 0.08) !important;
    }
</style>

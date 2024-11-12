<!DOCTYPE html>

<html
    @if(App::getLocale() == 'en')
        lang="en" dir="ltr"
    @else
        lang="ar" dir="rtl"
    @endif
    class="light-style layout-navbar-fixed layout-menu-fixed" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="School System" />
    <meta name="author" content="Abdullah Mohamed" />
    <!-- Title -->
    <title>{{ trans('layouts/sidebar.program') }}</title>

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
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->

    <!--- Page css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/pages/page-auth.css') }}" />
    <style>
        a.badge{
            font-size: 2rem;
        }
        .badge {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.1); /* Makes the button slightly larger */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Adds a shadow effect */
        }
    </style>


    <!-- Helpers -->
    <script src="{{ URL::asset('assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ URL::asset('assets/js/config.js') }}"></script>

</head>

@if(App::getLocale() == 'ar')
<body style="font-family:Cairo, system-ui !important;">
@else
<body>
@endif
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">{{ trans('auth.guardSelection') }}</h5>
                        </div>
                        <div class="nav-item dropdown-language dropdown me-2 me-xl-0">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                @if (App::getLocale() == 'ar')
                                    <i class="fi fi-eg fis rounded-circle me-1 fs-3"></i>
                                @else
                                    <i class="fi fi-us fis rounded-circle me-1 fs-3"></i>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <i class="fi @if ($localeCode == 'ar') fi-eg @else fi-us @endif fis rounded-circle me-1 fs-3"></i>
                                            <span class="align-middle">{{ $properties['native'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card-body text-center pt-1">
                        <a class="badge rounded-pill p-2 me-4 bg-label-info" href="{{ route('login.show', 'parent') }}">
                            <i class="mdi mdi-account-tie-outline"></i>
                        </a>
                        <a class="badge rounded-pill p-2 me-4 bg-label-warning" href="{{ route('login.show', 'teacher') }}">
                            <i class="mdi mdi-human-male-board-poll"></i>
                        </a>
                        <a class="badge rounded-pill p-2 me-4 bg-label-success" href="{{ route('login.show', 'student') }}">
                            <i class="mdi mdi-account-school-outline"></i>
                        </a>
                        <a class="badge rounded-pill p-2 bg-label-danger" href="{{ route('login.show', 'admin') }}">
                            <i class="mdi mdi-account-cog-outline"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ URL::asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ URL::asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ URL::asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ URL::asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ URL::asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->

</body>

</html>

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
    @include('layouts.head')
</head>

@if(App::getLocale() == 'ar')
<body style="font-family:Cairo, system-ui !important;">
@else
<body>
@endif
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('layouts.sidebar')

            <!-- Layout container -->
            <div class="layout-page">

                @include('layouts.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @include('layouts.breadcrumb')

                        @yield('content')
                    </div>
                    <!-- / Content -->

                    @include('layouts.footer')

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    @include('layouts.scripts')
</body>

</html>

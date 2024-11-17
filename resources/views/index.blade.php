@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/pages/cards-advance.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection

@section('pageTitle')
    Home
@endsection

@section('breadcrumb1')
    Dashboard
@endsection

@section('breadcrumb2')
    Home
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Statistics</h5>
                    <small
                        class="text-muted">{{ \Carbon\Carbon::now()->locale(app()->getLocale())->translatedFormat('l, j F Y') }}</small>
                </div>
                <div class="card-body pt-2">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                    <i class="ti ti-chart-pie-2 ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">230k</h5>
                                    <small>Sales</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2">
                                    <i class="ti ti-users ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">8.549k</h5>
                                    <small>Customers</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">1.423k</h5>
                                    <small>Products</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-currency-dollar ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">$9745</h5>
                                    <small>Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="badge rounded-pill p-2 bg-label-danger mb-2">
                        <i class="ti ti-briefcase ti-sm"></i>
                    </div>
                    <h5 class="card-title mb-2">97.8k</h5>
                    <small>Orders</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="badge rounded-pill p-2 bg-label-success mb-2">
                        <i class="ti ti-message-dots ti-sm"></i>
                    </div>
                    <h5 class="card-title mb-2">3.4k</h5>
                    <small>Review</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card app-calendar-wrapper">
        <div class="row g-0">
            <!-- Calendar Sidebar -->
            <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
                <div class="border-bottom p-4 my-sm-0 mb-3">
                    <div class="d-grid">
                        <button class="btn btn-primary btn-toggle-sidebar" data-bs-toggle="offcanvas"
                            data-bs-target="#addEventSidebar" aria-controls="addEventSidebar">
                            <i class="ti ti-plus me-1"></i>
                            <span class="align-middle">Add Event</span>
                        </button>
                    </div>
                </div>
                <div class="p-3">
                    <!-- inline calendar (flatpicker) -->
                    <div class="inline-calendar"></div>

                    <hr class="container-m-nx mb-4 mt-3" />

                    <!-- Filter -->
                    <div class="mb-3 ms-3">
                        <small class="text-small text-muted text-uppercase align-middle">Filter</small>
                    </div>

                    <div class="form-check mb-2 ms-3">
                        <input class="form-check-input select-all" type="checkbox" id="selectAll" data-value="all"
                            checked />
                        <label class="form-check-label" for="selectAll">View All</label>
                    </div>

                    <div class="app-calendar-events-filter ms-3">
                        <div class="form-check form-check-danger mb-2">
                            <input class="form-check-input input-filter" type="checkbox" id="select-personal"
                                data-value="personal" checked />
                            <label class="form-check-label" for="select-personal">Personal</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                data-value="business" checked />
                            <label class="form-check-label" for="select-business">Business</label>
                        </div>
                        <div class="form-check form-check-warning mb-2">
                            <input class="form-check-input input-filter" type="checkbox" id="select-family"
                                data-value="family" checked />
                            <label class="form-check-label" for="select-family">Family</label>
                        </div>
                        <div class="form-check form-check-success mb-2">
                            <input class="form-check-input input-filter" type="checkbox" id="select-holiday"
                                data-value="holiday" checked />
                            <label class="form-check-label" for="select-holiday">Holiday</label>
                        </div>
                        <div class="form-check form-check-info">
                            <input class="form-check-input input-filter" type="checkbox" id="select-etc"
                                data-value="etc" checked />
                            <label class="form-check-label" for="select-etc">ETC</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Calendar Sidebar -->

            <!-- Calendar & Modal -->
            <div class="col app-calendar-content">
                <div class="card shadow-none border-0">
                    <div class="card-body pb-0">
                        <!-- FullCalendar -->
                        <div id="calendar"></div>
                    </div>
                </div>
                <div class="app-overlay"></div>
                <!-- FullCalendar Offcanvas -->
                <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                    aria-labelledby="addEventSidebarLabel">
                    <div class="offcanvas-header my-1">
                        <h5 class="offcanvas-title" id="addEventSidebarLabel">Add Event</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body pt-0">
                        <form class="event-form pt-0" id="eventForm" onsubmit="return false">
                            <div class="mb-3">
                                <label class="form-label" for="eventTitle">Title</label>
                                <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                    placeholder="Event Title" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="eventLabel">Label</label>
                                <select class="select2 select-event-label form-select" id="eventLabel" name="eventLabel">
                                    <option data-label="primary" value="Business" selected>Business</option>
                                    <option data-label="danger" value="Personal">Personal</option>
                                    <option data-label="warning" value="Family">Family</option>
                                    <option data-label="success" value="Holiday">Holiday</option>
                                    <option data-label="info" value="ETC">ETC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="eventStartDate">Start Date</label>
                                <input type="text" class="form-control" id="eventStartDate" name="eventStartDate"
                                    placeholder="Start Date" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="eventEndDate">End Date</label>
                                <input type="text" class="form-control" id="eventEndDate" name="eventEndDate"
                                    placeholder="End Date" />
                            </div>
                            <div class="mb-3">
                                <label class="switch">
                                    <input type="checkbox" class="switch-input allDay-switch" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label">All Day</span>
                                </label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="eventURL">Event URL</label>
                                <input type="url" class="form-control" id="eventURL" name="eventURL"
                                    placeholder="https://www.google.com" />
                            </div>
                            <div class="mb-3 select2-primary">
                                <label class="form-label" for="eventGuests">Add Guests</label>
                                <select class="select2 select-event-guests form-select" id="eventGuests"
                                    name="eventGuests" multiple>
                                    <option data-avatar="1.png" value="Jane Foster">Jane Foster</option>
                                    <option data-avatar="3.png" value="Donna Frank">Donna Frank</option>
                                    <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                                    <option data-avatar="7.png" value="Lori Spears">Lori Spears</option>
                                    <option data-avatar="9.png" value="Sandy Vega">Sandy Vega</option>
                                    <option data-avatar="11.png" value="Cheryl May">Cheryl May</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="eventLocation">Location</label>
                                <input type="text" class="form-control" id="eventLocation" name="eventLocation"
                                    placeholder="Enter Location" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="eventDescription">Description</label>
                                <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                            </div>
                            <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                    <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                        data-bs-dismiss="offcanvas">
                                        Cancel
                                    </button>
                                </div>
                                <div><button class="btn btn-label-danger btn-delete-event d-none">Delete</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Calendar & Modal -->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ URL::asset('assets/js/cards-statistics.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app-calendar-events.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app-calendar.js') }}"></script>
@endsection

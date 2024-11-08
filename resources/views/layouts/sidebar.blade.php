<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Abdullah</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Program Name -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('layouts/sidebar.program') }}</span>
        </li>
        <!-- Home -->
        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon mdi mdi-home-outline"></i>
                <div>{{ trans('layouts/sidebar.home') }}</div>
            </a>
        </li>

        <!-- School Management -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('layouts/sidebar.schoolManagement') }}</span>
        </li>
        <!-- Stages -->
        <li class="menu-item">
            <a href="{{ route('stages') }}" class="menu-link">
                <i class="menu-icon mdi mdi-school-outline"></i>
                <div>{{ trans('layouts/sidebar.stages') }}</div>
            </a>
        </li>
        <!-- Grades -->
        <li class="menu-item">
            <a href="{{ route('grades') }}" class="menu-link">
                <i class="menu-icon mdi mdi-clipboard-outline"></i>
                <div>{{ trans('layouts/sidebar.grades') }}</div>
            </a>
        </li>
        <!-- Classes -->
        <li class="menu-item">
            <a href="{{ route('getStagesWithClassrooms') }}" class="menu-link">
                <i class="menu-icon mdi mdi-view-list-outline"></i>
                <div>{{ trans('layouts/sidebar.classrooms') }}</div>
            </a>
        </li>
        <!-- Subjects -->
        <li class="menu-item">
            <a href="{{ route('subjects') }}" class="menu-link">
                <i class="menu-icon mdi mdi-book-outline"></i>
                <div>{{ trans('layouts/sidebar.subjects') }}</div>
            </a>
        </li>

        <!-- Students Management -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('layouts/sidebar.studentsManagement') }}</span>
        </li>
        <!-- Students -->
        <li class="menu-item">
            <a href="{{ route('students') }}" class="menu-link">
                <i class="menu-icon mdi mdi-account-group-outline"></i>
                <div>{{ trans('layouts/sidebar.students') }}</div>
            </a>
        </li>
        <!-- Promotions -->
        <li class="menu-item">
            <a href="{{ route('promotions') }}" class="menu-link">
                <i class="menu-icon mdi mdi-account-switch-outline"></i>
                <div>{{ trans('layouts/sidebar.promotions') }}</div>
            </a>
        </li>
        <!-- Graduations -->
        <li class="menu-item">
            <a href="{{ route('graduations') }}" class="menu-link">
                <i class="menu-icon mdi mdi-account-school-outline"></i>
                <div>{{ trans('layouts/sidebar.graduations') }}</div>
            </a>
        </li>

        <!-- Users -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('layouts/sidebar.users') }}</span>
        </li>
        <!-- Parents -->
        <li class="menu-item">
            <a href="{{ route('parents') }}" class="menu-link">
                <i class="menu-icon mdi mdi-account-tie-outline"></i>
                <div>{{ trans('layouts/sidebar.parents') }}</div>
            </a>
        </li>
        <!-- Teachers -->
        <li class="menu-item">
            <a href="{{ route('teachers') }}" class="menu-link">
                <i class="menu-icon mdi mdi-human-male-board-poll"></i>
                <div>{{ trans('layouts/sidebar.teachers') }}</div>
            </a>
        </li>
        <!-- Users List -->
        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon mdi mdi-account-multiple-outline"></i>
                <div>{{ trans('layouts/sidebar.usersList') }}</div>
            </a>
        </li>

        <!-- Finance -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('layouts/sidebar.finance') }}</span>
        </li>
        <!-- Tuition Fees -->
        <li class="menu-item">
            <a href="{{ route('fees') }}" class="menu-link">
                <i class="menu-icon mdi mdi-cash-multiple"></i>
                <div>{{ trans('layouts/sidebar.fees') }}</div>
            </a>
        </li>
        <!-- Invoices -->
        <li class="menu-item">
            <a href="{{ route('invoices') }}" class="menu-link">
                <i class="menu-icon mdi mdi-invoice-text-multiple-outline"></i>
                <div>{{ trans('layouts/sidebar.invoices') }}</div>
            </a>
        </li>
        <!-- Receipts -->
        <li class="menu-item">
            <a href="{{ route('receipts') }}" class="menu-link">
                <i class="menu-icon mdi mdi-cash-plus"></i>
                <div>{{ trans('layouts/sidebar.receipts') }}</div>
            </a>
        </li>
        <!-- Payments -->
        <li class="menu-item">
            <a href="{{ route('payments') }}" class="menu-link">
                <i class="menu-icon mdi mdi-cash-minus"></i>
                <div>{{ trans('layouts/sidebar.payments') }}</div>
            </a>
        </li>
        <!-- Refunds -->
        <li class="menu-item">
            <a href="{{ route('refunds') }}" class="menu-link">
                <i class="menu-icon mdi mdi-cash-refund"></i>
                <div>{{ trans('layouts/sidebar.refunds') }}</div>
            </a>
        </li>

        <!-- Student Activities -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('layouts/sidebar.studentActivities') }}</span>
        </li>
        <!-- Attendances -->
        <li class="menu-item">
            <a href="{{ route('attendances') }}" class="menu-link">
                <i class="menu-icon mdi mdi-calendar-month-outline"></i>
                <div>{{ trans('layouts/sidebar.attendances') }}</div>
            </a>
        </li>
        <!-- Exams -->
        <li class="menu-item">
            <a href="{{ route('quizzes') }}" class="menu-link">
                <i class="menu-icon mdi mdi-clipboard-text-outline"></i>
                <div>{{ trans('layouts/sidebar.quizzes') }}</div>
            </a>
        </li>
        <!-- Library -->
        <li class="menu-item">
            <a href="{{ route('library') }}" class="menu-link">
                <i class="menu-icon mdi mdi-bookshelf"></i>
                <div>{{ trans('layouts/sidebar.library') }}</div>
            </a>
        </li>
        <!-- Online Classes -->
        <li class="menu-item">
            <a href="{{ route('onlineClasses') }}" class="menu-link">
                <i class="menu-icon mdi mdi-video-outline"></i>
                <div>{{ trans('layouts/sidebar.onlineClasses') }}</div>
            </a>
        </li>

        <!-- Additional Settings -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('layouts/sidebar.misc') }}</span>
        </li>
        <!-- Settings -->
        <li class="menu-item">
            <a href="{{ route('settings') }}" class="menu-link">
                <i class="menu-icon mdi mdi-cog-outline"></i>
                <div>{{ trans('layouts/sidebar.settings') }}</div>
            </a>
        </li>
        <!-- Contact Me -->
        <li class="menu-item">
            <a href="" class="menu-link">
                <i class="menu-icon mdi mdi-headset"></i>
                <div>{{ trans('layouts/sidebar.contact') }}</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->

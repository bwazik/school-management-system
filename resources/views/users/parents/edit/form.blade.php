<div class="col-12 mb-4">
    @if (Session::has('message'))
    <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
        <span class="alert-icon text-primary me-2">
            <i class="ti ti-check ti-xs"></i>
        </span>
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="bs-stepper wizard-numbered mt-2">
        <div class="bs-stepper-header">
            <div class="step {{ $currentStep != 1 ? '' : 'active' }}" data-target="#step-1">
                <button type="button" class="step-trigger" aria-selected="true">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">{{ trans('users/parents.step1Title') }}</span>
                        <span class="bs-stepper-subtitle">{{ trans('users/parents.step1P') }}</span>
                    </span>
                </button>
            </div>
            <div class="line">
                <i class="ti ti-chevron-right"></i>
            </div>
            <div class="step {{ $currentStep != 2 ? '' : 'active' }}" data-target="#step-2">
                <button type="button" class="step-trigger" aria-selected="false">
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">{{ trans('users/parents.step2Title') }}</span>
                        <span class="bs-stepper-subtitle">{{ trans('users/parents.step2P') }}</span>
                    </span>
                </button>
            </div>
        </div>


        <div class="bs-stepper-content">
            @include('users.parents.edit.father')
            @include('users.parents.edit.mother')
        </div>
    </div>
</div>

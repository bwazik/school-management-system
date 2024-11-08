<div class="col-12 mb-4">
    @if (!empty($successMessage))
        <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
            <span class="alert-icon text-primary me-2">
                <i class="ti ti-check ti-xs"></i>
            </span>
            {{ $successMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($dataTable)
        @include('users.parents.table')
    @else
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
            <div class="line">
                <i class="ti ti-chevron-right"></i>
            </div>
            <div class="step {{ $currentStep != 3 ? '' : 'active' }}" data-target="#step-3">
                <button type="button" class="step-trigger" aria-selected="false">
                    <span class="bs-stepper-circle">3</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">{{ trans('users/parents.step3Title') }}</span>
                        <span class="bs-stepper-subtitle">{{ trans('users/parents.step3P') }}</span>
                    </span>
                </button>
            </div>
        </div>


        <div class="bs-stepper-content">
            @include('users.parents.father')
            @include('users.parents.mother')

            <div id="step-3" class="content {{ $currentStep != 3 ? '' : 'active dstepper-block' }}">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="alert alert-primary alert-dismissible" role="alert">
                            <h5 class="alert-heading mb-2">{{ trans('users/parents.attachmentsAlertHead') }}</h5>
                            <p class="mb-0">
                                {{ trans('users/parents.attachmentsAlertP') }}
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <input type="file" class="form-control @error('attachments.*') is-invalid @enderror @error('attachments') is-invalid @enderror" id="attachments" accept="image/jpg, image/jpeg, image/png" wire:model="attachments" multiple>
                            <label class="input-group-text" for="attachments">[jpeg , jpg , png]</label>
                            @error('attachments.*')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            @error('attachments')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-label-secondary btn-prev waves-effect" wire:click="back(2)">
                            <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">{{ trans('users/parents.previous') }}</span>
                        </button>
                        <button class="btn btn-success btn-submit waves-effect waves-light" wire:click="submitForm">{{ trans('users/parents.submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

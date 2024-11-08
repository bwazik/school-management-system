<div id="step-1" class="content {{ $currentStep != 1 ? '' : 'active dstepper-block' }}">
    <div class="row g-3">
        <div class="col-sm-6">
            <label class="form-label" for="email">{{ trans('users/parents.email') }}</label>
            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" wire:model.live="email"
                placeholder="bwazik@outlook.com">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="password">{{ trans('users/parents.password') }}</label>
            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" wire:model.live="password"
                placeholder="············">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="father_name_ar">{{ trans('users/parents.father_name_ar') }}</label>
            <input type="text" id="father_name_ar" class="form-control @error('father_name_ar') is-invalid @enderror" wire:model.lazy="father_name_ar"
                placeholder="عبدالله محمد">
            @error('father_name_ar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="father_name_en">{{ trans('users/parents.father_name_en') }}</label>
            <input type="text" id="father_name_en" class="form-control @error('father_name_en') is-invalid @enderror" wire:model.lazy="father_name_en"
                placeholder="Abdullah Mohamed">
            @error('father_name_en')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="father_job_ar">{{ trans('users/parents.father_job_ar') }}</label>
            <input type="text" id="father_job_ar" class="form-control @error('father_job_ar') is-invalid @enderror" wire:model.lazy="father_job_ar"
                placeholder="عامل نظافة">
            @error('father_job_ar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="father_job_en">{{ trans('users/parents.father_job_en') }}</label>
            <input type="text" id="father_job_en" class="form-control @error('father_job_en') is-invalid @enderror" wire:model.lazy="father_job_en"
                placeholder="Cleaner">
            @error('father_job_en')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-2">
            <label class="form-label" for="father_national_id">{{ trans('users/parents.father_national_id') }}</label>
            <input type="number" id="father_national_id" class="form-control @error('father_national_id') is-invalid @enderror" wire:model.live="father_national_id"
                placeholder="1234567890">
            @error('father_national_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-2">
            <label class="form-label" for="father_passport_id">{{ trans('users/parents.father_passport_id') }}</label>
            <input type="number" id="father_passport_id" class="form-control @error('father_passport_id') is-invalid @enderror" wire:model.live="father_passport_id"
                placeholder="1234567890">
            @error('father_passport_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-2">
            <label class="form-label" for="father_phone">{{ trans('users/parents.father_phone') }}</label>
            <input type="number" id="father_phone" class="form-control @error('father_phone') is-invalid @enderror" wire:model.live="father_phone"
                placeholder="01098617164">
            @error('father_phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="father_nationality">{{ trans('users/parents.father_nationality') }}</label>
            <select id="father_nationality" class="form-select @error('father_nationality') is-invalid @enderror" wire:model.lazy="father_nationality">
                    <option selected value="">{{ trans('users/parents.choose') }}</option>
                @foreach ($nationalities as $nationality)
                    <option value="{{ $nationality -> id }}"> {{ $nationality -> name }} </option>
                @endforeach
            </select>
            @error('father_nationality')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="father_blood_type">{{ trans('users/parents.father_blood_type') }}</label>
            <select id="father_blood_type" class="form-select @error('father_blood_type') is-invalid @enderror" wire:model.lazy="father_blood_type">
                    <option selected value="">{{ trans('users/parents.choose') }}</option>
                @foreach ($bloods as $bloods)
                    <option value="{{ $bloods -> id }}"> {{ $bloods -> name }} </option>
                @endforeach
            </select>
            @error('father_blood_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="father_religion">{{ trans('users/parents.father_religion') }}</label>
            <select id="father_religion" class="form-select @error('father_religion') is-invalid @enderror" wire:model.lazy="father_religion">
                    <option selected value="">{{ trans('users/parents.choose') }}</option>
                @foreach ($religions as $religion)
                    <option value="{{ $religion -> id }}"> {{ $religion -> name }} </option>
                @endforeach
            </select>
            @error('father_religion')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="father_address_ar">{{ trans('users/parents.father_address_ar') }}</label>
            <textarea rows="4" maxlength="150" id="father_address_ar" class="form-control @error('father_address_ar') is-invalid @enderror" wire:model="father_address_ar"
                placeholder="القاهرة, مصر, شارع 21...">
            </textarea>
            @error('father_address_ar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="father_address_en">{{ trans('users/parents.father_address_en') }}</label>
            <textarea rows="4" maxlength="150" id="father_address_en" class="form-control @error('father_address_en') is-invalid @enderror" wire:model="father_address_en"
            placeholder="Egypt, Cairo, 21st ...">
            </textarea>
            @error('father_address_en')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="col-12 d-flex justify-content-between">
            <button href="{{ route('parents') }}" class="btn btn-label-secondary btn-prev waves-effect" wire:click="showDataTable">
                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">{{ trans('layouts/sidebar.parents') }}</span>
            </button>
            <button class="btn btn-primary btn-next waves-effect waves-light" wire:click="firstStepSubmit">
                <span class="align-middle d-sm-inline-block d-none me-sm-1">{{ trans('users/parents.next') }}</span>
                <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </div>
</div>


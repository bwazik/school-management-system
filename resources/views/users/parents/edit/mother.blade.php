<div id="step-2" class="content {{ $currentStep != 2 ? '' : 'active dstepper-block' }}">
    <div class="row g-3">
        <div class="col-sm-6">
            <label class="form-label" for="mother_name_ar">{{ trans('users/parents.mother_name_ar') }}</label>
            <input type="text" id="mother_name_ar" class="form-control @error('mother_name_ar') is-invalid @enderror" wire:model.lazy="mother_name_ar"
                placeholder="منار محمد">
            @error('mother_name_ar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="mother_name_en">{{ trans('users/parents.mother_name_en') }}</label>
            <input type="text" id="mother_name_en" class="form-control @error('mother_name_en') is-invalid @enderror" wire:model.lazy="mother_name_en"
                placeholder="Manar Mohamed">
            @error('mother_name_en')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="mother_job_ar">{{ trans('users/parents.mother_job_ar') }}</label>
            <input type="text" id="mother_job_ar" class="form-control @error('mother_job_ar') is-invalid @enderror" wire:model.lazy="mother_job_ar"
                placeholder="عاملة نظافة">
            @error('mother_job_ar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="mother_job_en">{{ trans('users/parents.mother_job_en') }}</label>
            <input type="text" id="mother_job_en" class="form-control @error('mother_job_en') is-invalid @enderror" wire:model.lazy="mother_job_en"
                placeholder="Cleaner">
            @error('mother_job_en')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-2">
            <label class="form-label" for="mother_national_id">{{ trans('users/parents.mother_national_id') }}</label>
            <input type="number" id="mother_national_id" class="form-control @error('mother_national_id') is-invalid @enderror" wire:model.live="mother_national_id"
                placeholder="1234567890">
            @error('mother_national_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-2">
            <label class="form-label" for="mother_passport_id">{{ trans('users/parents.mother_passport_id') }}</label>
            <input type="number" id="mother_passport_id" class="form-control @error('mother_passport_id') is-invalid @enderror" wire:model.live="mother_passport_id"
                placeholder="1234567890">
            @error('mother_passport_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-2">
            <label class="form-label" for="mother_phone">{{ trans('users/parents.mother_phone') }}</label>
            <input type="number" id="mother_phone" class="form-control @error('mother_phone') is-invalid @enderror" wire:model.live="mother_phone"
                placeholder="01098617164">
            @error('mother_phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="mother_nationality">{{ trans('users/parents.mother_nationality') }}</label>
            <select id="mother_nationality" class="form-select @error('mother_nationality') is-invalid @enderror" wire:model.lazy="mother_nationality">
                    <option selected value="">{{ trans('users/parents.choose') }}</option>
                @foreach ($nationalities as $nationality)
                    <option value="{{ $nationality -> id }}"> {{ $nationality -> name }} </option>
                @endforeach
            </select>
            @error('mother_nationality')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="mother_blood_type">{{ trans('users/parents.mother_blood_type') }}</label>
            <select id="mother_blood_type" class="form-select @error('mother_blood_type') is-invalid @enderror" wire:model.lazy="mother_blood_type">
                    <option selected value="">{{ trans('users/parents.choose') }}</option>
                @foreach ($bloods as $bloods)
                    <option value="{{ $bloods -> id }}"> {{ $bloods -> name }} </option>
                @endforeach
            </select>
            @error('mother_blood_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label" for="mother_religion">{{ trans('users/parents.mother_religion') }}</label>
            <select id="mother_religion" class="form-select @error('mother_religion') is-invalid @enderror" wire:model.lazy="mother_religion">
                    <option selected value="">{{ trans('users/parents.choose') }}</option>
                @foreach ($religions as $religion)
                    <option value="{{ $religion -> id }}"> {{ $religion -> name }} </option>
                @endforeach
            </select>
            @error('mother_religion')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="mother_address_ar">{{ trans('users/parents.mother_address_ar') }}</label>
            <textarea rows="4" maxlength="150" id="mother_address_ar" class="form-control @error('mother_address_ar') is-invalid @enderror" wire:model="mother_address_ar"
                placeholder="القاهرة, مصر, شارع 21...">
            </textarea>
            @error('mother_address_ar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="mother_address_en">{{ trans('users/parents.mother_address_en') }}</label>
            <textarea rows="4" maxlength="150" id="mother_address_en" class="form-control @error('mother_address_en') is-invalid @enderror" wire:model="mother_address_en"
                placeholder="Egypt, Cairo, 21st ...">
            </textarea>
            @error('mother_address_en')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-label-secondary btn-prev waves-effect" wire:click="back(1)">
                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">{{ trans('users/parents.previous') }}</span>
            </button>
            <button class="btn btn-success btn-submit waves-effect waves-light" wire:click="submitForm">{{ trans('users/parents.submit') }}</button>
        </div>
    </div>
</div>

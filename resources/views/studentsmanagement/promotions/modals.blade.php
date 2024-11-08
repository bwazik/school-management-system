<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" id="add-promotion-button" data-bs-toggle="modal" data-bs-target="#add-promotion-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/promotions.addPromotion') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="revert-selected-btn">
                        <span>
                            <i style="font-size: 1.25rem" class="mdi mdi-arrow-u-right-top me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/promotions.revertSelected') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="graduate-selected-btn">
                        <span>
                            <i style="font-size: 1.25rem" class="mdi mdi-school-outline me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/promotions.graduateSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/promotions.export') }}</span>
                            </span><span class="dt-down-arrow"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dt-button dropdown-item print-button" tabindex="0" aria-controls="datatable" href="#"><span><i class="ti ti-printer me-1"></i>Print</span></a>
                            <a class="dt-button dropdown-item csv-button buttons-html5" tabindex="0" aria-controls="datatable" href="#"><span><i class="ti ti-file-text me-1"></i>Csv</span></a>
                            <a class="dt-button dropdown-item excel-button buttons-html5" tabindex="0" aria-controls="datatable" href="#"><span><i class="ti ti-file-spreadsheet me-1"></i>Excel</span></a>
                            <a class="dt-button dropdown-item pdf-button buttons-html5" tabindex="0" aria-controls="datatable" href="#"><span><i class="ti ti-file-description me-1"></i>Pdf</span></a>
                            <a class="dt-button dropdown-item copy-button buttons-html5" tabindex="0" aria-controls="datatable" href="#"><span><i class="ti ti-copy me-1"></i>Copy</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table id="datatable" class="datatables-basic table" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th><input trname="select_all" id="select_all" type="checkbox" class="dt-checkboxes form-check-input"
                            onclick="CheckAll('box1', this)"></th>
                    <th>#</th>
                    <th>{{ trans('studentsmanagement/promotions.name') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.from_stage') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.from_grade') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.from_classroom') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.from_academic_year') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.to_stage') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.to_grade') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.to_classroom') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.to_academic_year') }}</th>
                    <th>{{ trans('studentsmanagement/promotions.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Student -->
<div class="modal fade" id="add-promotion-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/promotions.addPromotion') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-form" action="{{ route('addPromotion') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="from_stage_id">{{ trans('studentsmanagement/promotions.from_stage') }}</label>
                            <select id="from_stage_id" name="from_stage_id" class="select2Add form-select">
                                @foreach ($stages as $stage)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $stage -> id }}"> {{ $stage -> name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="from_stage_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="from_grade_id">{{ trans('studentsmanagement/promotions.from_grade') }}</label>
                            <select id="from_grade_id" name="from_grade_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="from_grade_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="from_classroom_id">{{ trans('studentsmanagement/promotions.from_classroom') }}</label>
                            <select id="from_classroom_id" name="from_classroom_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="from_classroom_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="from_academic_year">{{ trans('studentsmanagement/promotions.from_academic_year') }}</label>
                            <select id="from_academic_year" name="from_academic_year" class="select2Add form-select">
                                <option selected disabled value=""></option>
                                <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                                <option value="{{ date("Y") + 1 }}">{{ date("Y") + 1 }}</option>
                            </select>
                            <span class="invalid-feedback" id="from_academic_year_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="to_stage_id">{{ trans('studentsmanagement/promotions.to_stage') }}</label>
                            <select id="to_stage_id" name="to_stage_id" class="select2Add form-select">
                                @foreach ($stages as $stage)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $stage -> id }}"> {{ $stage -> name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="to_stage_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="to_grade_id">{{ trans('studentsmanagement/promotions.to_grade') }}</label>
                            <select id="to_grade_id" name="to_grade_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="to_grade_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="to_classroom_id">{{ trans('studentsmanagement/promotions.to_classroom') }}</label>
                            <select id="to_classroom_id" name="to_classroom_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="to_classroom_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="to_academic_year">{{ trans('studentsmanagement/promotions.to_academic_year') }}</label>
                            <select id="to_academic_year" name="to_academic_year" class="select2Add form-select">
                                <option selected disabled value=""></option>
                                <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                                <option value="{{ date("Y") + 1 }}">{{ date("Y") + 1 }}</option>
                            </select>
                            <span class="invalid-feedback" id="to_academic_year_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/promotions.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('studentsmanagement/promotions.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Revert Student -->
<div class="modal fade" id="revert-student-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/promotions.revertStudent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/promotions.revertWarning') }}
                <form id="revert-form" action="{{ route('revertStudent') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="row">
                        <div class="col mt-2">
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/promotions.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Revert Selected Students -->
<div class="modal fade" id="revert-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/promotions.revertSelectedStudents') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/promotions.revertWarning') }}
                <form id="revert-selected-form" action="{{ route('revertSelectedStudents') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/promotions.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Graduate Student -->
<div class="modal fade" id="graduate-student-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/promotions.graduateStudent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/promotions.graduateWarning') }}
                <form id="graduate-form" action="{{ route('graduateStudent') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="row">
                        <div class="col mt-2">
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/promotions.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Graduate Selected Students -->
<div class="modal fade" id="graduate-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/promotions.graduateSelectedStudents') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/promotions.graduateWarning') }}
                <form id="graduate-selected-form" action="{{ route('graduateSelectedStudents') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/promotions.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

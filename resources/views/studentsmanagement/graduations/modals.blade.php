<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" id="add-graduation-button" data-bs-toggle="modal" data-bs-target="#add-graduation-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/graduations.addGraduation') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="return-selected-btn">
                        <span>
                            <i style="font-size: 1.25rem" class="mdi mdi-arrow-u-right-top me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/graduations.returnSelected') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/graduations.deleteSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('studentsmanagement/graduations.export') }}</span>
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
                    <th>{{ trans('studentsmanagement/graduations.email') }}</th>
                    <th>{{ trans('studentsmanagement/graduations.name') }}</th>
                    <th>{{ trans('studentsmanagement/graduations.stage') }}</th>
                    <th>{{ trans('studentsmanagement/graduations.grade') }}</th>
                    <th>{{ trans('studentsmanagement/graduations.classroom') }}</th>
                    <th>{{ trans('studentsmanagement/graduations.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Graduation -->
<div class="modal fade" id="add-graduation-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/graduations.addGraduation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-form" action="{{ route('addGraduation') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="stage_id">{{ trans('studentsmanagement/graduations.stage') }}</label>
                            <select id="stage_id" name="stage_id" class="select2Add form-select">
                                @foreach ($stages as $stage)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $stage -> id }}"> {{ $stage -> name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="stage_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="grade_id">{{ trans('studentsmanagement/graduations.grade') }}</label>
                            <select id="grade_id" name="grade_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="classroom_id">{{ trans('studentsmanagement/graduations.classroom') }}</label>
                            <select id="classroom_id" name="classroom_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="classroom_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="academic_year">{{ trans('studentsmanagement/graduations.academic_year') }}</label>
                            <select id="academic_year" name="academic_year" class="select2Add form-select">
                                <option selected disabled value=""></option>
                                <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                                <option value="{{ date("Y") + 1 }}">{{ date("Y") + 1 }}</option>
                            </select>
                            <span class="invalid-feedback" id="academic_year_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/graduations.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('studentsmanagement/graduations.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Return Student -->
<div class="modal fade" id="return-student-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/graduations.returnStudent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/graduations.returnWarning') }}
                <form id="return-form" action="{{ route('returnStudent') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/graduations.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('studentsmanagement/students.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Return Selected Students -->
<div class="modal fade" id="return-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/graduations.returnSelectedStudents') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/graduations.returnWarning') }}
                <form id="return-selected-form" action="{{ route('returnSelectedStudents') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/graduations.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Student -->
<div class="modal fade" id="delete-student-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/graduations.deleteStudent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/graduations.deleteWarning') }}
                <form id="delete-form" action="{{ route('forceDeleteStudent') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/graduations.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('studentsmanagement/students.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Students -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/graduations.deleteSelectedStudents') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/graduations.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('forceDeleteSelectedStudents') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentsmanagement/graduations.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('studentsmanagement/students.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

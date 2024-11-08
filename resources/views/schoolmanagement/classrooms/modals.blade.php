<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        aria-controls="add-classroom-modal" type="button" id="add-classroom-button" data-bs-toggle="offcanvas"
                        data-bs-target="#add-classroom-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('schoolmanagement/classrooms.addClassroom') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button
                            class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light"
                            data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button"
                            aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span
                                    class="d-none d-sm-inline-block">{{ trans('schoolmanagement/classrooms.export') }}</span>
                            </span><span class="dt-down-arrow"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dt-button dropdown-item print-button" tabindex="0" aria-controls="datatable"
                                href="#"><span><i class="ti ti-printer me-1"></i>Print</span></a>
                            <a class="dt-button dropdown-item csv-button buttons-html5" tabindex="0"
                                aria-controls="datatable" href="#"><span><i
                                        class="ti ti-file-text me-1"></i>Csv</span></a>
                            <a class="dt-button dropdown-item excel-button buttons-html5" tabindex="0"
                                aria-controls="datatable" href="#"><span><i
                                        class="ti ti-file-spreadsheet me-1"></i>Excel</span></a>
                            <a class="dt-button dropdown-item pdf-button buttons-html5" tabindex="0"
                                aria-controls="datatable" href="#"><span><i
                                        class="ti ti-file-description me-1"></i>Pdf</span></a>
                            <a class="dt-button dropdown-item copy-button buttons-html5" tabindex="0"
                                aria-controls="datatable" href="#"><span><i
                                        class="ti ti-copy me-1"></i>Copy</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="accordion mt-3 accordion-bordered" id="accordionExample">
                @foreach ($stagesWithClassrooms as $stage)
                    <div class="card accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-url="{{ route('getAllClassrooms', $stage -> id) }}"
                                data-bs-target="#accordion-{{ $stage -> id }}" aria-expanded="false" aria-controls="accordion-{{ $stage -> id }}">
                                {{ $stage -> name }}
                            </button>
                        </h2>
                        <div id="accordion-{{ $stage -> id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                            style="">
                            <div class="accordion-body">
                                <table id="datatable-{{ $stage -> id }}" data-stage-id={{ $stage -> id }} class="datatables-basic table" style="white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('schoolmanagement/classrooms.name') }}</th>
                                            <th>{{ trans('schoolmanagement/classrooms.grade') }}</th>
                                            <th>{{ trans('schoolmanagement/classrooms.status') }}</th>
                                            <th>{{ trans('schoolmanagement/classrooms.createdDate') }}</th>
                                            <th>{{ trans('schoolmanagement/classrooms.actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Add Classroom -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add-classroom-modal" aria-labelledby="add-classroom-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('schoolmanagement/classrooms.addClassroom') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="add-form" action="{{ route('addClassroom') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('schoolmanagement/classrooms.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : الفصل A  " />
                <span class="invalid-feedback" id="name_ar_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('schoolmanagement/classrooms.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Classroom B" />
                <span class="invalid-feedback" id="name_en_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('schoolmanagement/classrooms.stage') }}</label>
                <select id="stage_id" name="stage_id" class="select2Add form-select">
                    @foreach ($stagesWithClassrooms as $stage)
                        <option selected disabled value=""></option>
                        <option value="{{ $stage -> id }}"> {{ $stage -> name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="stage_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="grade_id">{{ trans('schoolmanagement/classrooms.grade') }}</label>
                <select id="grade_id" name="grade_id" class="select2Add form-select">
                        <option selected disabled value=""></option>
                </select>
                <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="teachers">{{ trans('schoolmanagement/classrooms.teachers') }}</label>
                <select id="teachers" name="teachers[]" class="select2Add form-select" multiple>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher -> id }}"> {{ $teacher -> name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="teachers_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="status">{{ trans('schoolmanagement/classrooms.status') }}</label>
                <select id="status" name="status" class="select2Add form-select">
                    <option selected disabled value=""></option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <span class="invalid-feedback" id="status_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('schoolmanagement/classrooms.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('schoolmanagement/classrooms.close') }}</button>
        </form>
    </div>
</div>

<!-- Edit Classroom -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="edit-classroom-modal" aria-labelledby="edit-classroom-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('schoolmanagement/classrooms.editClassroom') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="edit-form" action="{{ route('editClassroom') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('schoolmanagement/classrooms.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : الفصل A  " />
                <span class="invalid-feedback" id="name_ar_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('schoolmanagement/classrooms.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Classroom B" />
                <span class="invalid-feedback" id="name_en_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('schoolmanagement/classrooms.stage') }}</label>
                <select id="stage_id" name="stage_id" class="select2Edit form-select">
                    @foreach ($stagesWithClassrooms as $stage)
                        <option selected disabled value=""></option>
                        <option value="{{ $stage -> id }}"> {{ $stage -> name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="stage_id_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="grade_id">{{ trans('schoolmanagement/classrooms.grade') }}</label>
                <select id="grade_id" name="grade_id" class="select2Edit form-select">
                    @foreach ($grades as $grade)
                        <option selected disabled value=""></option>
                        <option value="{{ $grade -> id }}">({{ $grade -> stage -> name }}) -  {{ $grade -> name }}</option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="grade_id_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="teachers">{{ trans('schoolmanagement/classrooms.teachers') }}</label>
                <select id="teachers" name="teachers[]" class="select2Add form-select" multiple>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher -> id }}"> {{ $teacher -> name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="teachers_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="status">{{ trans('schoolmanagement/classrooms.status') }}</label>
                <select id="status" name="status" class="select2Edit form-select">
                    <option selected disabled value=""></option>
                    <option value="1">{{ trans('schoolmanagement/classrooms.active') }}</option>
                    <option value="0">{{ trans('schoolmanagement/classrooms.inactive') }}</option>
                </select>
                <span class="invalid-feedback" id="status_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('schoolmanagement/classrooms.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('schoolmanagement/classrooms.close') }}</button>
        </form>
    </div>
</div>

<!-- Delete Classroom -->
<div class="modal fade" id="delete-classroom-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('schoolmanagement/classrooms.deleteClassroom') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('schoolmanagement/classrooms.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteClassroom') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="stage_id" name="stage_id" value="">
                    <div class="row">
                        <div class="col mt-2">
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('schoolmanagement/classrooms.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('schoolmanagement/classrooms.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

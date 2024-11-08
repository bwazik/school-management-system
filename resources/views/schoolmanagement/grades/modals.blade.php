<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="add-grade-modal" type="button" id="add-grade-button" data-bs-toggle="offcanvas" data-bs-target="#add-grade-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('schoolmanagement/grades.addGrade') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('schoolmanagement/grades.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle hide-arrow waves-effect waves-light me-2" data-bs-toggle="dropdown" data-trigger="hover" aria-expanded="false">{{ trans('schoolmanagement/grades.filterByStage') }}</button>
                        <ul class="dropdown-menu" style="">
                            @foreach ($stages as $stage)
                            <li>
                                <form action="{{ route('filterByStage') }}" method="POST" style="display: none;" class="filter-form" id="form-{{ $stage -> id }}">
                                    @csrf
                                    <input type="hidden" name="stage_id" id="stage_id" value="{{ $stage -> id }}">
                                </form>
                                <a class="dropdown-item dropdown-item-filter cursor-pointer" data-id="{{ $stage -> id }}">{{ $stage -> name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('schoolmanagement/grades.export') }}</span>
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
                    <th><input name="select_all" id="select_all" type="checkbox" class="dt-checkboxes form-check-input"
                            onclick="CheckAll('box1', this)"></th>
                    <th>#</th>
                    <th>{{ trans('schoolmanagement/grades.name') }}</th>
                    <th>{{ trans('schoolmanagement/grades.stage') }}</th>
                    <th>{{ trans('schoolmanagement/grades.createdDate') }}</th>
                    <th>{{ trans('schoolmanagement/grades.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Grade -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add-grade-modal" aria-labelledby="add-grade-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('schoolmanagement/grades.addGrade') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="add-form" action="{{ route('addGrade') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('schoolmanagement/grades.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : الصف الدراسي الثاني" />
                <span class="invalid-feedback" id="name_ar_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('schoolmanagement/grades.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Grade 1" />
                <span class="invalid-feedback" id="name_en_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('schoolmanagement/grades.stage') }}</label>
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
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('schoolmanagement/grades.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('schoolmanagement/grades.close') }}</button>
        </form>
    </div>
</div>

<!-- Edit Grade -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="edit-grade-modal" aria-labelledby="edit-grade-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('schoolmanagement/grades.editGrade') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="edit-form" action="{{ route('editGrade') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('schoolmanagement/grades.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : الصف الدراسي الثاني" />
                <span class="invalid-feedback" id="name_ar_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('schoolmanagement/grades.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Grade 1" />
                <span class="invalid-feedback" id="name_en_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('schoolmanagement/grades.stage') }}</label>
                <select id="stage_id" name="stage_id" class="select2Edit form-select">
                    @foreach ($stages as $stage)
                        <option value="{{ $stage -> id }}"> {{ $stage -> name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="stage_id_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('schoolmanagement/grades.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('schoolmanagement/grades.close') }}</button>
        </form>
    </div>
</div>

<!-- Delete Grade -->
<div class="modal fade" id="delete-grade-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('schoolmanagement/grades.deleteGrade') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('schoolmanagement/stages.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteGrade') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('schoolmanagement/grades.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('schoolmanagement/grades.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Grades -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('schoolmanagement/grades.deleteSelectedGrades') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('schoolmanagement/stages.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedGrades') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('schoolmanagement/stages.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('schoolmanagement/stages.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

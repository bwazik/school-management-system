<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="add-subject-modal" type="button" id="add-subject-button" data-bs-toggle="offcanvas" data-bs-target="#add-subject-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('schoolmanagement/subjects.addSubject') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('schoolmanagement/subjects.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('schoolmanagement/subjects.export') }}</span>
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
                    <th>{{ trans('schoolmanagement/subjects.name') }}</th>
                    <th>{{ trans('schoolmanagement/subjects.createdDate') }}</th>
                    <th>{{ trans('schoolmanagement/subjects.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Subject -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add-subject-modal" aria-labelledby="add-subject-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('schoolmanagement/subjects.addSubject') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="add-form" action="{{ route('addSubject') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('schoolmanagement/subjects.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : اللغة العربية" />
                <span class="invalid-feedback" id="name_ar_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('schoolmanagement/subjects.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Arabic" />
                <span class="invalid-feedback" id="name_en_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('schoolmanagement/subjects.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('schoolmanagement/subjects.close') }}</button>
        </form>
    </div>
</div>

<!-- Edit Subject -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="edit-subject-modal" aria-labelledby="edit-subject-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('schoolmanagement/subjects.editSubject') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="edit-form" action="{{ route('editSubject') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('schoolmanagement/subjects.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : اللغة العربية" />
                <span class="invalid-feedback" id="name_ar_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('schoolmanagement/subjects.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Arabic" />
                <span class="invalid-feedback" id="name_en_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('schoolmanagement/subjects.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('schoolmanagement/subjects.close') }}</button>
        </form>
    </div>
</div>

<!-- Delete Subject -->
<div class="modal fade" id="delete-subject-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('schoolmanagement/subjects.deleteSubject') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('schoolmanagement/subjects.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteSubject') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('schoolmanagement/subjects.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('schoolmanagement/subjects.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Subjects -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('schoolmanagement/subjects.deleteSelectedSubjects') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('schoolmanagement/subjects.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedSubjects') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('schoolmanagement/subjects.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('schoolmanagement/subjects.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

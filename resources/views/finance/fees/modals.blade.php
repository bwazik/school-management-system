<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="add-fee-modal" type="button" id="add-fee-button" data-bs-toggle="offcanvas" data-bs-target="#add-fee-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('finance/fees.addFee') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('finance/fees.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('finance/fees.export') }}</span>
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
                    <th>{{ trans('finance/fees.name') }}</th>
                    <th>{{ trans('finance/fees.amount') }}</th>
                    <th>{{ trans('finance/fees.stage') }}</th>
                    <th>{{ trans('finance/fees.grade') }}</th>
                    <th>{{ trans('finance/fees.year') }}</th>
                    <th>{{ trans('finance/fees.createdDate') }}</th>
                    <th>{{ trans('finance/fees.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Fee -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add-fee-modal" aria-labelledby="add-fee-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('finance/fees.addFee') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="add-form" action="{{ route('addFee') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('finance/fees.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : رسوم النقل" />
                <span class="invalid-feedback" id="name_ar_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('finance/fees.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Transport Fee" />
                <span class="invalid-feedback" id="name_en_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="amount">{{ trans('finance/fees.amount') }}</label>
                <div class="input-group">
                    <input type="number" id="amount" class="form-control" name="amount" placeholder="5,000" step=".01"/>
                    <span class="input-group-text">$</span>
                </div>
                <span class="invalid-feedback" id="amount_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('finance/fees.stage') }}</label>
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
            <div class="mb-3">
                <label class="form-label" for="grade_id">{{ trans('finance/fees.grade') }}</label>
                <select id="grade_id" name="grade_id" class="select2Add form-select">
                        <option selected disabled value=""></option>
                </select>
                <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="year">{{ trans('finance/fees.year') }}</label>
                <select id="year" name="year" class="select2Add form-select">
                    <option selected disabled value=""></option>
                    <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                    <option value="{{ date("Y") + 1 }}">{{ date("Y") + 1 }}</option>
                </select>
                <span class="invalid-feedback" id="year_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('finance/fees.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('finance/fees.close') }}</button>
        </form>
    </div>
</div>

<!-- Edit Fee -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="edit-fee-modal" aria-labelledby="edit-fee-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('finance/fees.editFee') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="edit-form" action="{{ route('editFee') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('finance/fees.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : رسوم النقل" />
                <span class="invalid-feedback" id="name_ar_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('finance/fees.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Transport Fee" />
                <span class="invalid-feedback" id="name_en_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="amount">{{ trans('finance/fees.amount') }}</label>
                <input type="number" id="amount" class="form-control" name="amount"
                    placeholder="5,000$" step=".01"/>
                <span class="invalid-feedback" id="amount_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('finance/fees.stage') }}</label>
                <select id="stage_id" name="stage_id" class="select2Add form-select">
                    @foreach ($stages as $stage)
                        <option selected disabled value=""></option>
                        <option value="{{ $stage -> id }}"> {{ $stage -> name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="stage_id_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="grade_id">{{ trans('finance/fees.grade') }}</label>
                <select id="grade_id" name="grade_id" class="select2Add form-select">
                    @foreach ($grades as $grade)
                    <option selected disabled value=""></option>
                    <option value="{{ $grade -> id }}">({{ $grade -> stage -> name }}) - {{ $grade -> name }}</option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="grade_id_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="year">{{ trans('finance/fees.year') }}</label>
                <select id="year" name="year" class="select2Add form-select">
                    <option selected disabled value=""></option>
                    <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                    <option value="{{ date("Y") + 1 }}">{{ date("Y") + 1 }}</option>
                </select>
                <span class="invalid-feedback" id="year_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('finance/fees.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('finance/fees.close') }}</button>
        </form>
    </div>
</div>

<!-- Delete Fee -->
<div class="modal fade" id="delete-fee-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('finance/fees.deleteFee') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('finance/fees.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteFee') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('finance/fees.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('finance/fees.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Fees -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('finance/fees.deleteSelectedFees') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('finance/fees.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedFees') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('finance/fees.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('finance/fees.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

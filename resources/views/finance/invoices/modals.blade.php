<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="add-invoice-modal" type="button" id="add-invoice-button" data-bs-toggle="offcanvas" data-bs-target="#add-invoice-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('finance/invoices.addInvoice') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('finance/invoices.export') }}</span>
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
                    <th>#</th>
                    <th>{{ trans('finance/invoices.fee') }}</th>
                    <th>{{ trans('finance/invoices.amount') }}</th>
                    <th>{{ trans('finance/invoices.date') }}</th>
                    <th>{{ trans('finance/invoices.student') }}</th>
                    <th>{{ trans('finance/invoices.stage') }}</th>
                    <th>{{ trans('finance/invoices.grade') }}</th>
                    <th>{{ trans('finance/invoices.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Invoice -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add-invoice-modal" aria-labelledby="add-invoice-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('finance/invoices.addInvoice') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="add-form" action="{{ route('addInvoice') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label class="form-label" for="student_id">{{ trans('finance/invoices.student') }}</label>
                <select id="student_id" name="student_id" class="select2Add form-select">
                    @foreach ($students as $student)
                        <option selected disabled value=""></option>
                        <option value="{{ $student -> id }}"> {{ $student -> name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="student_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage">{{ trans('finance/invoices.stage') }}</label>
                <input type="text" id="stage" class="form-control student-name-input" readonly>
                <input type="hidden" id="stage_id" name="stage_id">
                <span class="invalid-feedback" id="stage_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="grade">{{ trans('finance/invoices.grade') }}</label>
                <input type="text" id="grade" class="form-control student-name-input" readonly>
                <input type="hidden"id="grade_id" name="grade_id">
                <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="fee">{{ trans('finance/invoices.fee') }}</label>
                <select id="fees" name="fees" class="select2Add form-select">
                </select>
                <span class="invalid-feedback" id="fees_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="amount">{{ trans('finance/invoices.amount') }}</label>
                <div class="input-group">
                    <input type="text" id="amount" name="amount" class="form-control student-name-input" readonly>
                    <span class="input-group-text">$</span>
                </div>
                <span class="invalid-feedback" id="amount_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit" class="btn btn-success data-submit me-sm-3 me-1">{{ trans('finance/invoices.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ trans('finance/invoices.close') }}</button>
        </form>
    </div>
</div>

<!-- Delete Invoice -->
<div class="modal fade" id="delete-invoice-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('finance/invoices.deleteInvoice') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('finance/invoices.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteInvoice') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('finance/invoices.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('finance/invoices.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

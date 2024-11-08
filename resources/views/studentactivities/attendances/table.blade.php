
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-success waves-effect waves-light me-2" id="attendance-button" data-bs-toggle="modal" data-bs-target="#attendance-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('studentactivities/attendances.addAttendance') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('studentactivities/attendances.export') }}</span>
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

        <form id="attendance-form" method="POST" action="{{ route('addAttendance') }}" style="overflow: auto">
            @csrf
            <table id="datatable" class="datatables-basic table" style="white-space: nowrap;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('studentactivities/attendances.name') }}</th>
                        <th>{{ trans('studentactivities/attendances.email') }}</th>
                        <th>{{ trans('layouts/sidebar.attendances') }}</th>
                    </tr>
                </thead>
            </table>
        </form>
    </div>
</div>

<!-- Attendance Teacher -->
<div class="modal fade" id="attendance-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentactivities/attendances.addAttendance') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/attendances.addWarning') }}
                <div class="row">
                    <div class="col mt-2">
                        <input type="text" id="name" class="form-control"  value="{{ trans('studentactivities/attendances.date') }} : {{ date('Y-m-d') }}" disabled>
                    </div>
                </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('studentactivities/attendances.close') }}</button>
                <button type="button" class="btn btn-success" id="add-attendance-btn">{{ trans('studentactivities/attendances.submit') }}</button>
            </div>
        </div>
    </div>
</div>

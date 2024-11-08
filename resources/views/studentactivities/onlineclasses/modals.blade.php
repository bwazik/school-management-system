<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" id="add-online-class-button"
                        data-bs-toggle="modal" data-bs-target="#add-online-class-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/onlineclasses.addOnlineClass') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/onlineclasses.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button
                            class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light"
                            data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button"
                            aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span
                                    class="d-none d-sm-inline-block">{{ trans('studentactivities/onlineclasses.export') }}</span>
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
        <table id="datatable" class="datatables-basic table" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th><input name="select_all" id="select_all" type="checkbox" class="dt-checkboxes form-check-input"
                            onclick="CheckAll('box1', this)"></th>
                    <th>#</th>
                    <th>{{ trans('studentactivities/onlineclasses.topic') }}</th>
                    <th>{{ trans('studentactivities/onlineclasses.teacher') }}</th>
                    <th>{{ trans('studentactivities/onlineclasses.duration') }}</th>
                    <th>{{ trans('studentactivities/onlineclasses.start_time') }}</th>
                    <th>{{ trans('studentactivities/onlineclasses.join_url') }}</th>
                    <th>{{ trans('studentactivities/onlineclasses.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Online Class -->
<div class="modal fade" id="add-online-class-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/onlineclasses.addOnlineClass') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-form" action="{{ route('addOnlineClass') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="stage_id">{{ trans('studentactivities/onlineclasses.stage') }}</label>
                            <select id="stage_id" name="stage_id" class="select2Add form-select">
                                @foreach ($stages as $stage)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $stage->id }}"> {{ $stage->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="stage_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="grade_id">{{ trans('studentactivities/onlineclasses.grade') }}</label>
                            <select id="grade_id" name="grade_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="classroom_id">{{ trans('studentactivities/onlineclasses.classroom') }}</label>
                            <select id="classroom_id" name="classroom_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="classroom_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="parent_id">{{ trans('studentactivities/onlineclasses.teacher') }}</label>
                            <select id="teacher_id" name="teacher_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="teacher_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="topic_ar">{{ trans('studentactivities/onlineclasses.topic_ar') }}</label>
                            <input type="text" id="topic_ar" class="form-control" name="topic_ar"
                                placeholder="مثال: مراجعة اللغة الإنجليزية" />
                            <span class="invalid-feedback" id="topic_ar_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="topic_en">{{ trans('studentactivities/onlineclasses.topic_en') }}</label>
                            <input type="text" id="topic_en" class="form-control" name="topic_en"
                                placeholder="Ex: English Revision" />
                            <span class="invalid-feedback" id="topic_en_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="duration">{{ trans('studentactivities/onlineclasses.duration') }}</label>
                            <input type="number" id="duration" class="form-control" name="duration"
                                placeholder="60">
                            <span class="invalid-feedback" id="duration_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md">
                            <label class="form-label"
                                for="start_time">{{ trans('studentactivities/onlineclasses.start_time') }}</label>
                            <input type="text" id="start_time" class="form-control flatpickr-datetime"
                                name="start_time" placeholder="YYYY-MM-DD HH:MM" readonly="readonly">
                            <span class="invalid-feedback" id="start_time_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md">
                            <label class="form-label"
                                for="password">{{ trans('studentactivities/onlineclasses.password') }}</label>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="············" autocomplete="off" />
                            <span class="invalid-feedback" id="password_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/onlineclasses.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentactivities/onlineclasses.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Online Class -->
<div class="modal fade" id="edit-online-class-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/onlineclasses.editOnlineClass') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="edit-form" action="{{ route('editOnlineClass') }}" method="POST" autocomplete="off">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="meeting_id" id="meeting_id" value="">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="stage_id">{{ trans('studentactivities/onlineclasses.stage') }}</label>
                            <select id="stage_id" name="stage_id" class="select2Add form-select">
                                @foreach ($stages as $stage)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $stage->id }}"> {{ $stage->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="stage_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="grade_id">{{ trans('studentactivities/onlineclasses.grade') }}</label>
                            <select id="grade_id" name="grade_id" class="select2Add form-select">
                                @foreach ($grades as $grade)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $grade->id }}">({{ $grade->stage->name }}) - {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="grade_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="classroom_id">{{ trans('studentactivities/onlineclasses.classroom') }}</label>
                            <select id="classroom_id" name="classroom_id" class="select2Add form-select">
                                @foreach ($classrooms as $classroom)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $classroom->id }}">({{ $classroom->stage->name }}) - ({{ $classroom->grade->name }}) - {{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="classroom_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="parent_id">{{ trans('studentactivities/onlineclasses.teacher') }}</label>
                            <select id="teacher_id" name="teacher_id" class="select2Add form-select">
                                @foreach ($teachers as $teacher)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="teacher_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="topic_ar">{{ trans('studentactivities/onlineclasses.topic_ar') }}</label>
                            <input type="text" id="topic_ar" class="form-control" name="topic_ar"
                                placeholder="مثال: مراجعة اللغة الإنجليزية" />
                            <span class="invalid-feedback" id="topic_ar_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="topic_en">{{ trans('studentactivities/onlineclasses.topic_en') }}</label>
                            <input type="text" id="topic_en" class="form-control" name="topic_en"
                                placeholder="Ex: English Revision" />
                            <span class="invalid-feedback" id="topic_en_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md">
                            <label class="form-label"
                                for="duration">{{ trans('studentactivities/onlineclasses.duration') }}</label>
                            <input type="number" id="duration" class="form-control" name="duration"
                                placeholder="60">
                            <span class="invalid-feedback" id="duration_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md">
                            <label class="form-label"
                                for="start_time">{{ trans('studentactivities/onlineclasses.start_time') }}</label>
                            <input type="text" id="start_time" class="form-control flatpickr-datetime"
                                name="start_time" placeholder="YYYY-MM-DD HH:MM" readonly="readonly">
                            <span class="invalid-feedback" id="start_time_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/onlineclasses.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentactivities/onlineclasses.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Online Class -->
<div class="modal fade" id="delete-online-class-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="online-classpleModalLabel1">{{ trans('studentactivities/onlineclasses.deleteOnlineClass') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/onlineclasses.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteOnlineClass') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" name="meeting_id" id="meeting_id" value="">
                    <div class="row">
                        <div class="col mt-2">
                            <input type="text" id="topic" class="form-control" disabled>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/onlineclasses.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/onlineclasses.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Online Classes -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="online-classpleModalLabel1">
                    {{ trans('studentactivities/onlineclasses.deleteSelectedOnlineClasses') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/onlineclasses.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedOnlineClasses') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/onlineclasses.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/onlineclasses.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

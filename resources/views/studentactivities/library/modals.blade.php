<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" id="add-book-button"
                        data-bs-toggle="modal" data-bs-target="#add-book-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/library.addBook') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/library.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button
                            class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light"
                            data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button"
                            aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span
                                    class="d-none d-sm-inline-block">{{ trans('studentactivities/library.export') }}</span>
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
                    <th>{{ trans('studentactivities/library.title') }}</th>
                    <th>{{ trans('studentactivities/library.teacher') }}</th>
                    <th>{{ trans('studentactivities/library.stage') }}</th>
                    <th>{{ trans('studentactivities/library.grade') }}</th>
                    <th>{{ trans('studentactivities/library.classroom') }}</th>
                    <th>{{ trans('studentactivities/library.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Book -->
<div class="modal fade" id="add-book-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/library.addBook') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-form" action="{{ route('addBook') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="title_ar">{{ trans('studentactivities/library.title_ar') }}</label>
                            <input type="text" id="title_ar" class="form-control" name="title_ar"
                                placeholder="مثال : كتاب اللغة العربية  " />
                            <span class="invalid-feedback" id="title_ar_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="title_en">{{ trans('studentactivities/library.title_en') }}</label>
                            <input type="text" id="title_en" class="form-control" name="title_en"
                                placeholder="ex : Arabic Book" />
                            <span class="invalid-feedback" id="title_en_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="stage_id">{{ trans('studentactivities/library.stage') }}</label>
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
                                for="grade_id">{{ trans('studentactivities/library.grade') }}</label>
                            <select id="grade_id" name="grade_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="classroom_id">{{ trans('studentactivities/library.classroom') }}</label>
                            <select id="classroom_id" name="classroom_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="classroom_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="parent_id">{{ trans('studentactivities/library.teacher') }}</label>
                            <select id="teacher_id" name="teacher_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="teacher_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label class="form-label" for="file">{{ trans('studentactivities/library.file') }}</label>
                            <div class="input-group">
                                <input type="file" name="file" class="form-control" id="file" accept=".pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx, .jpg, .jpeg, .png, .txt, .mp4, .mov">
                            </div>
                            <span class="invalid-feedback" id="file_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/library.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentactivities/library.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Book -->
<div class="modal fade" id="edit-book-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentactivities/library.editBook') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="edit-form" action="{{ route('editBook') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row g-4">
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="title_ar">{{ trans('studentactivities/library.title_ar') }}</label>
                            <input type="text" id="title_ar" class="form-control" name="title_ar"
                                placeholder="مثال : كتاب اللغة العربية  " />
                            <span class="invalid-feedback" id="title_ar_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md mb-4">
                            <label class="form-label"
                                for="title_en">{{ trans('studentactivities/library.title_en') }}</label>
                            <input type="text" id="title_en" class="form-control" name="title_en"
                                placeholder="ex : Arabic Book" />
                            <span class="invalid-feedback" id="title_en_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md">
                            <label class="form-label"
                                for="stage_id">{{ trans('studentactivities/library.stage') }}</label>
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
                        <div class="col-md">
                            <label class="form-label"
                                for="grade_id">{{ trans('studentactivities/library.grade') }}</label>
                            <select id="grade_id" name="grade_id" class="select2Add form-select">
                                @foreach ($grades as $grade)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $grade->id }}">({{ $grade->stage->name }}) - {{ $grade->name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="grade_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md">
                            <label class="form-label"
                                for="classroom_id">{{ trans('studentactivities/library.classroom') }}</label>
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
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/library.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentactivities/library.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Book -->
<div class="modal fade" id="delete-book-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizpleModalLabel1">{{ trans('studentactivities/library.deleteBook') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/quizzes.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteBook') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="row">
                        <div class="col mt-2">
                            <input type="text" id="title" class="form-control" disabled>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/library.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/library.delete') }}</button>
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
                    {{ trans('studentactivities/library.deleteSelectedBooks') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/library.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedBooks') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/library.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/library.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

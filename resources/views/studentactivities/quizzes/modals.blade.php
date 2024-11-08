<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        aria-controls="add-quiz-modal" type="button" id="add-quiz-button" data-bs-toggle="offcanvas"
                        data-bs-target="#add-quiz-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/quizzes.addQuiz') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentactivities/quizzes.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button
                            class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light"
                            data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button"
                            aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span
                                    class="d-none d-sm-inline-block">{{ trans('studentactivities/quizzes.export') }}</span>
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
                    <th>{{ trans('studentactivities/quizzes.name') }}</th>
                    <th>{{ trans('studentactivities/quizzes.teacher') }}</th>
                    <th>{{ trans('studentactivities/quizzes.subject') }}</th>
                    <th>{{ trans('studentactivities/quizzes.stage') }}</th>
                    <th>{{ trans('studentactivities/quizzes.grade') }}</th>
                    <th>{{ trans('studentactivities/quizzes.classroom') }}</th>
                    <th>{{ trans('studentactivities/quizzes.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Quiz -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add-quiz-modal" aria-labelledby="add-quiz-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('studentactivities/quizzes.addQuiz') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="add-form" action="{{ route('addQuiz') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('studentactivities/quizzes.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : إمتحان الفصل الدراسي الأول " />
                <span class="invalid-feedback" id="name_ar_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('studentactivities/quizzes.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : First Term Quiz" />
                <span class="invalid-feedback" id="name_en_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('studentactivities/quizzes.stage') }}</label>
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
            <div class="mb-3">
                <label class="form-label" for="grade_id">{{ trans('studentactivities/quizzes.grade') }}</label>
                <select id="grade_id" name="grade_id" class="select2Add form-select">
                    <option selected disabled value=""></option>
                </select>
                <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label"
                    for="classroom_id">{{ trans('studentactivities/quizzes.classroom') }}</label>
                <select id="classroom_id" name="classroom_id" class="select2Add form-select">
                    <option selected disabled value=""></option>
                </select>
                <span class="invalid-feedback" id="classroom_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="teacher_id">{{ trans('studentactivities/quizzes.teacher') }}</label>
                <select id="teacher_id" name="teacher_id" class="select2Add form-select">
                    <option selected disabled value=""></option>
                </select>
                <span class="invalid-feedback" id="teacher_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="subject_id">{{ trans('studentactivities/quizzes.subject') }}</label>
                <select id="subject_id" name="subject_id" class="select2Add form-select">
                    @foreach ($subjects as $subject)
                        <option selected disabled value=""></option>
                        <option value="{{ $subject->id }}"> {{ $subject->name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="subject_id_add_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit"
                class="btn btn-success data-submit me-sm-3 me-1">{{ trans('studentactivities/quizzes.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary"
                data-bs-dismiss="offcanvas">{{ trans('studentactivities/quizzes.close') }}</button>
        </form>
    </div>
</div>

<!-- Edit Quiz -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="edit-quiz-modal" aria-labelledby="edit-quiz-modalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ trans('studentactivities/quizzes.editQuiz') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="edit-form" action="{{ route('editQuiz') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="mb-3 mt-3">
                <label class="form-label" for="name_ar">{{ trans('studentactivities/quizzes.name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="مثال : اللغة العربية" />
                <span class="invalid-feedback" id="name_ar_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_en">{{ trans('studentactivities/quizzes.name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="ex : Arabic" />
                <span class="invalid-feedback" id="name_en_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="stage_id">{{ trans('studentactivities/quizzes.stage') }}</label>
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
            <div class="mb-3">
                <label class="form-label" for="grade_id">{{ trans('studentactivities/quizzes.grade') }}</label>
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
            <div class="mb-3">
                <label class="form-label" for="classroom_id">{{ trans('studentactivities/quizzes.classroom') }}</label>
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
            <div class="mb-3">
                <label class="form-label" for="teacher_id">{{ trans('studentactivities/quizzes.teacher') }}</label>
                <select id="teacher_id" name="teacher_id" class="select2Add form-select">
                    @foreach ($teachers as $teacher)
                        <option selected disabled value=""></option>
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="teacher_id_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="subject_id">{{ trans('studentactivities/quizzes.subject') }}</label>
                <select id="subject_id" name="subject_id" class="select2Add form-select">
                    @foreach ($subjects as $subject)
                        <option selected disabled value=""></option>
                        <option value="{{ $subject->id }}"> {{ $subject->name }} </option>
                    @endforeach
                </select>
                <span class="invalid-feedback" id="subject_id_edit_error" role="alert">
                    <strong></strong>
                </span>
            </div>
            <button type="submit"
                class="btn btn-success data-submit me-sm-3 me-1">{{ trans('studentactivities/quizzes.submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary"
                data-bs-dismiss="offcanvas">{{ trans('studentactivities/quizzes.close') }}</button>
        </form>
    </div>
</div>

<!-- Delete Quiz -->
<div class="modal fade" id="delete-quiz-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizpleModalLabel1">{{ trans('studentactivities/quizzes.deleteQuiz') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/quizzes.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteQuiz') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/quizzes.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/quizzes.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Quizzes -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizpleModalLabel1">
                    {{ trans('studentactivities/quizzes.deleteSelectedQuizzes') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentactivities/quizzes.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedQuizzes') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentactivities/quizzes.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentactivities/quizzes.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

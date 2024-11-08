<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" id="add-student-button"
                        data-bs-toggle="modal" data-bs-target="#add-student-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentsmanagement/students.addStudent') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentsmanagement/students.deletSelected') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0"
                        aria-controls="datatable" type="button" id="graduate-selected-btn">
                        <span>
                            <i style="font-size: 1.25rem" class="mdi mdi-school-outline me-sm-1"></i>
                            <span
                                class="d-none d-sm-inline-block">{{ trans('studentsmanagement/promotions.graduateSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button
                            class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light"
                            data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button"
                            aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span
                                    class="d-none d-sm-inline-block">{{ trans('studentsmanagement/students.export') }}</span>
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
                    <th>{{ trans('studentsmanagement/students.email') }}</th>
                    <th>{{ trans('studentsmanagement/students.name') }}</th>
                    <th>{{ trans('studentsmanagement/students.stage') }}</th>
                    <th>{{ trans('studentsmanagement/students.grade') }}</th>
                    <th>{{ trans('studentsmanagement/students.classroom') }}</th>
                    <th>{{ trans('studentsmanagement/students.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Student -->
<div class="modal fade" id="add-student-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('studentsmanagement/students.addStudent') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-form" action="{{ route('addStudent') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="email">{{ trans('studentsmanagement/students.email') }}</label>
                            <input type="email" id="email" class="form-control" name="email"
                                placeholder="bwazik@outlook.com" autocomplete="off" />
                            <span class="invalid-feedback" id="email_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="password">{{ trans('studentsmanagement/students.password') }}</label>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="············" autocomplete="off" />
                            <span class="invalid-feedback" id="password_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="name_ar">{{ trans('studentsmanagement/students.name_ar') }}</label>
                            <input type="text" id="name_ar" class="form-control" name="name_ar"
                                placeholder="مثال : عبدالله محمد  " />
                            <span class="invalid-feedback" id="name_ar_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="name_en">{{ trans('studentsmanagement/students.name_en') }}</label>
                            <input type="text" id="name_en" class="form-control" name="name_en"
                                placeholder="ex : Abdullah Mohamed" />
                            <span class="invalid-feedback" id="name_en_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="stage_id">{{ trans('studentsmanagement/students.stage') }}</label>
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
                        <div class="col mb-4">
                            <label class="form-label"
                                for="grade_id">{{ trans('studentsmanagement/students.grade') }}</label>
                            <select id="grade_id" name="grade_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="grade_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="classroom_id">{{ trans('studentsmanagement/students.classroom') }}</label>
                            <select id="classroom_id" name="classroom_id" class="select2Add form-select">
                                <option selected disabled value=""></option>
                            </select>
                            <span class="invalid-feedback" id="classroom_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="parent_id">{{ trans('studentsmanagement/students.parent') }}</label>
                            <select id="parent_id" name="parent_id" class="select2Add form-select">
                                @foreach ($parents as $parent)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $parent->id }}">({{ $parent->father_name }}) -
                                        ({{ $parent->mother_name }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="parent_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="gender_id">{{ trans('studentsmanagement/students.gender') }}</label>
                            <select id="gender_id" name="gender_id" class="select2Add form-select">
                                @foreach ($genders as $gender)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $gender->id }}"> {{ $gender->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="gender_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="nationality">{{ trans('studentsmanagement/students.nationality') }}</label>
                            <select id="nationality" name="nationality" class="select2Add form-select">
                                @foreach ($nationalities as $nationality)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $nationality->id }}"> {{ $nationality->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="nationality_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="blood_type">{{ trans('studentsmanagement/students.blood_type') }}</label>
                            <select id="blood_type" name="blood_type" class="select2Add form-select">
                                @foreach ($bloods as $blood)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $blood->id }}"> {{ $blood->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="blood_type_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="religion">{{ trans('studentsmanagement/students.religion') }}</label>
                            <select id="religion" name="religion" class="select2Add form-select">
                                @foreach ($religions as $religion)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $religion->id }}"> {{ $religion->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="religion_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="birthday">{{ trans('studentsmanagement/students.birthday') }}</label>
                            <input type="text" id="birthday" class="form-control flatpickr-input"
                                name="birthday" placeholder="YYYY-MM-DD" readonly="readonly">
                            <span class="invalid-feedback" id="birthday_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="academic_year">{{ trans('studentsmanagement/students.academic_year') }}</label>
                            <select id="academic_year" name="academic_year" class="select2Add form-select">
                                <option selected disabled value=""></option>
                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                            </select>
                            <span class="invalid-feedback" id="academic_year_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student -->
<div class="modal fade" id="edit-student-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentsmanagement/students.editStudent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="edit-form" action="{{ route('editStudent') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="email">{{ trans('studentsmanagement/students.email') }}</label>
                            <input type="email" id="email" class="form-control" name="email"
                                placeholder="bwazik@outlook.com" autocomplete="off" />
                            <span class="invalid-feedback" id="email_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="password">{{ trans('studentsmanagement/students.password') }}</label>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="············" autocomplete="off" />
                            <span class="invalid-feedback" id="password_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="name_ar">{{ trans('studentsmanagement/students.name_ar') }}</label>
                            <input type="text" id="name_ar" class="form-control" name="name_ar"
                                placeholder="مثال : عبدالله محمد  " />
                            <span class="invalid-feedback" id="name_ar_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="name_en">{{ trans('studentsmanagement/students.name_en') }}</label>
                            <input type="text" id="name_en" class="form-control" name="name_en"
                                placeholder="ex : Abdullah Mohamed" />
                            <span class="invalid-feedback" id="name_en_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="stage_id">{{ trans('studentsmanagement/students.stage') }}</label>
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
                        <div class="col mb-4">
                            <label class="form-label"
                                for="grade_id">{{ trans('studentsmanagement/students.grade') }}</label>
                            <select id="grade_id" name="grade_id" class="select2Add form-select">
                                @foreach ($grades as $grade)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $grade->id }}">({{ $grade->stage->name }}) -
                                        {{ $grade->name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="grade_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="classroom_id">{{ trans('studentsmanagement/students.classroom') }}</label>
                            <select id="classroom_id" name="classroom_id" class="select2Add form-select">
                                @foreach ($classrooms as $classroom)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $classroom->id }}">({{ $classroom->stage->name }}) -
                                        ({{ $classroom->grade->name }})
                                        - {{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="classroom_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="parent_id">{{ trans('studentsmanagement/students.parent') }}</label>
                            <select id="parent_id" name="parent_id" class="select2Add form-select">
                                @foreach ($parents as $parent)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $parent->id }}">({{ $parent->father_name }}) -
                                        ({{ $parent->mother_name }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="parent_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="gender_id">{{ trans('studentsmanagement/students.gender') }}</label>
                            <select id="gender_id" name="gender_id" class="select2Add form-select">
                                @foreach ($genders as $gender)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $gender->id }}"> {{ $gender->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="gender_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="nationality">{{ trans('studentsmanagement/students.nationality') }}</label>
                            <select id="nationality" name="nationality" class="select2Add form-select">
                                @foreach ($nationalities as $nationality)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $nationality->id }}"> {{ $nationality->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="nationality_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="blood_type">{{ trans('studentsmanagement/students.blood_type') }}</label>
                            <select id="blood_type" name="blood_type" class="select2Add form-select">
                                @foreach ($bloods as $blood)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $blood->id }}"> {{ $blood->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="blood_type_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="religion">{{ trans('studentsmanagement/students.religion') }}</label>
                            <select id="religion" name="religion" class="select2Add form-select">
                                @foreach ($religions as $religion)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $religion->id }}"> {{ $religion->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="religion_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label"
                                for="birthday">{{ trans('studentsmanagement/students.birthday') }}</label>
                            <input type="text" id="birthday" class="form-control flatpickr-input"
                                name="birthday" placeholder="YYYY-MM-DD" readonly="readonly">
                            <span class="invalid-feedback" id="birthday_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label"
                                for="academic_year">{{ trans('studentsmanagement/students.academic_year') }}</label>
                            <select id="academic_year" name="academic_year" class="select2Add form-select">
                                <option selected disabled value=""></option>
                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                            </select>
                            <span class="invalid-feedback" id="academic_year_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
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
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentsmanagement/students.deleteStudent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/students.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteStudent') }}" method="POST">
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
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentsmanagement/students.delete') }}</button>
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
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentsmanagement/students.deleteSelectedStudents') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/students.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedStudents') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-danger">{{ trans('studentsmanagement/students.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Graduate Student -->
<div class="modal fade" id="graduate-student-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentsmanagement/promotions.graduateStudent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/promotions.graduateWarning') }}
                <form id="graduate-form" action="{{ route('mainGraduateStudent') }}" method="POST">
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
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Graduate Selected Students -->
<div class="modal fade" id="graduate-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('studentsmanagement/promotions.graduateSelectedStudents') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('studentsmanagement/promotions.graduateWarning') }}
                <form id="graduate-selected-form" action="{{ route('mainGraduateSelectedStudents') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Invoice -->
<div class="modal fade" id="add-invoice-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('finance/invoices.addInvoice') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-invoice-form" action="{{ route('addStudentInvoice') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="name">{{ trans('finance/invoices.student') }}</label>
                            <input type="text" id="name" name="name"
                                class="form-control student-name-input" disabled>
                            <span class="invalid-feedback" id="name_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="fee">{{ trans('finance/invoices.fee') }}</label>
                            <select id="fee" name="fee" class="select2Add form-select">
                                @foreach ($fees as $fee)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $fee->id }}"> {{ $fee->name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="fee_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="amount">{{ trans('finance/invoices.amount') }}</label>
                                <div class="input-group">
                                    <input type="text" id="amount" name="amount" class="form-control student-name-input" readonly>
                                    <span class="input-group-text">$</span>
                                </div>
                            <span class="invalid-feedback" id="amount_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Receipt -->
<div class="modal fade" id="add-receipt-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('finance/receipts.addReceipt') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-receipt-form" action="{{ route('addStudentReceipt') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="name">{{ trans('finance/receipts.student') }}</label>
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="balance">{{ trans('finance/receipts.balance') }}</label>
                            <div class="input-group">
                                <input type="text" id="balance" class="form-control" placeholder="0.00" disabled>
                                <span class="input-group-text">$</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="amount">{{ trans('finance/receipts.amount') }}</label>
                                <div class="input-group">
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="5,000" step=".01">
                                    <span class="input-group-text">$</span>
                                </div>
                            <span class="invalid-feedback" id="amount_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="description">{{ trans('finance/receipts.description') }}</label>
                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="مثال : سند قبض المصاريف المدرسية ومصاريف النقل والمواصلات"></textarea>
                            <span class="invalid-feedback" id="description_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment -->
<div class="modal fade" id="add-payment-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('finance/payments.addPayment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-payment-form" action="{{ route('addStudentPayment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="name">{{ trans('finance/payments.student') }}</label>
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="balance">{{ trans('finance/payments.balance') }}</label>
                            <div class="input-group">
                                <input type="text" id="balance" class="form-control" placeholder="0.00" disabled>
                                <span class="input-group-text">$</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="amount">{{ trans('finance/payments.amount') }}</label>
                                <div class="input-group">
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="5,000" step=".01">
                                    <span class="input-group-text">$</span>
                                </div>
                            <span class="invalid-feedback" id="amount_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="description">{{ trans('finance/payments.description') }}</label>
                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="مثال : سند قبض المصاريف المدرسية ومصاريف النقل والمواصلات"></textarea>
                            <span class="invalid-feedback" id="description_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add refund -->
<div class="modal fade" id="add-refund-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    {{ trans('finance/refunds.addRefund') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-refund-form" action="{{ route('addStudentRefund') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="name">{{ trans('finance/refunds.student') }}</label>
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="balance">{{ trans('finance/refunds.balance') }}</label>
                            <div class="input-group">
                                <input type="text" id="balance" class="form-control" placeholder="0.00" disabled>
                                <span class="input-group-text">$</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="amount">{{ trans('finance/refunds.amount') }}</label>
                                <div class="input-group">
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="5,000" step=".01">
                                    <span class="input-group-text">$</span>
                                </div>
                            <span class="invalid-feedback" id="amount_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="description">{{ trans('finance/refunds.description') }}</label>
                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="مثال : سند قبض المصاريف المدرسية ومصاريف النقل والمواصلات"></textarea>
                            <span class="invalid-feedback" id="description_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">{{ trans('studentsmanagement/students.close') }}</button>
                <button type="submit"
                    class="btn btn-success">{{ trans('studentsmanagement/students.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

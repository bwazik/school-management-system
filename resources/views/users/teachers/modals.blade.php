<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" id="add-teacher-button" data-bs-toggle="modal" data-bs-target="#add-teacher-modal">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('users/teachers.addTeacher') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('users/teachers.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('users/teachers.export') }}</span>
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
                    <th>{{ trans('users/teachers.email') }}</th>
                    <th>{{ trans('users/teachers.name') }}</th>
                    <th>{{ trans('users/teachers.subject') }}</th>
                    <th>{{ trans('users/teachers.joiningDate') }}</th>
                    <th>{{ trans('users/teachers.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Teacher -->
<div class="modal fade" id="add-teacher-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/teachers.addTeacher') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="add-form" action="{{ route('addTeacher') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="email">{{ trans('users/teachers.email') }}</label>
                            <input type="email" id="email" class="form-control" name="email"
                                placeholder="bwazik@outlook.com" autocomplete="off"/>
                            <span class="invalid-feedback" id="email_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="password">{{ trans('users/teachers.password') }}</label>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="············" autocomplete="off"/>
                            <span class="invalid-feedback" id="password_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="name_ar">{{ trans('users/teachers.name_ar') }}</label>
                            <input type="text" id="name_ar" class="form-control" name="name_ar"
                                placeholder="مثال : عبدالله محمد  " />
                            <span class="invalid-feedback" id="name_ar_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="name_en">{{ trans('users/teachers.name_en') }}</label>
                            <input type="text" id="name_en" class="form-control" name="name_en"
                                placeholder="ex : Abdullah Mohamed" />
                            <span class="invalid-feedback" id="name_en_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="subject_id">{{ trans('users/teachers.subject') }}</label>
                            <select id="subject_id" name="subject_id" class="select2Add form-select">
                                @foreach ($subjects as $subject)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $subject -> id }}"> {{ $subject -> name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="subject_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="gender_id">{{ trans('users/teachers.gender') }}</label>
                            <select id="gender_id" name="gender_id" class="select2Add form-select">
                                @foreach ($genders as $gender)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $gender -> id }}"> {{ $gender -> name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="gender_id_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="joining_date">{{ trans('users/teachers.joiningDate') }}</label>
                            <input type="text" id="joining_date" class="form-control flatpickr-input" name="joining_date" placeholder="YYYY-MM-DD" readonly="readonly">
                            <span class="invalid-feedback" id="joining_date_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="attachment">{{ trans('users/teachers.attachment') }}</label>
                            <div class="input-group">
                                <input type="file" name="attachment" class="form-control" id="attachment" accept="image/jpg, image/jpeg, image/png">
                                <label class="input-group-text" for="attachment">[jpeg , jpg , png]</label>
                            </div>
                            <span class="invalid-feedback" id="attachment_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="address">{{ trans('users/teachers.address') }}</label>
                            <textarea rows="4" maxlength="150" id="address" class="form-control" name="address" placeholder="123 st, Cairo"></textarea>
                            <span class="invalid-feedback" id="address_add_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('users/teachers.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('users/teachers.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Teacher -->
<div class="modal fade" id="edit-teacher-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/teachers.editTeacher') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                <form id="edit-form" action="{{ route('editTeacher') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="email">{{ trans('users/teachers.email') }}</label>
                            <input type="email" id="email" class="form-control" name="email"
                                placeholder="bwazik@outlook.com" autocomplete="off"/>
                            <span class="invalid-feedback" id="email_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="password">{{ trans('users/teachers.password') }}</label>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="············" autocomplete="off"/>
                            <span class="invalid-feedback" id="password_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="name_ar">{{ trans('users/teachers.name_ar') }}</label>
                            <input type="text" id="name_ar" class="form-control" name="name_ar"
                                placeholder="مثال : عبدالله محمد  " />
                            <span class="invalid-feedback" id="name_ar_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="name_en">{{ trans('users/teachers.name_en') }}</label>
                            <input type="text" id="name_en" class="form-control" name="name_en"
                                placeholder="ex : Abdullah Mohamed" />
                            <span class="invalid-feedback" id="name_en_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col mb-4">
                            <label class="form-label" for="subject_id">{{ trans('users/teachers.subject') }}</label>
                            <select id="subject_id" name="subject_id" class="select2Add form-select">
                                @foreach ($subjects as $subject)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $subject -> id }}"> {{ $subject -> name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="subject_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="gender_id">{{ trans('users/teachers.gender') }}</label>
                            <select id="gender_id" name="gender_id" class="select2Add form-select">
                                @foreach ($genders as $gender)
                                    <option selected disabled value=""></option>
                                    <option value="{{ $gender -> id }}"> {{ $gender -> name }} </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="gender_id_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label" for="joining_date">{{ trans('users/teachers.joiningDate') }}</label>
                            <input type="text" id="joining_date" class="form-control flatpickr-input" name="joining_date" placeholder="YYYY-MM-DD" readonly="readonly">
                            <span class="invalid-feedback" id="joining_date_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="address">{{ trans('users/teachers.address') }}</label>
                            <textarea rows="4" maxlength="150" id="address" class="form-control" name="address" placeholder="123 st, Cairo"></textarea>
                            <span class="invalid-feedback" id="address_edit_error" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('users/teachers.close') }}</button>
                <button type="submit" class="btn btn-success">{{ trans('users/teachers.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Teacher -->
<div class="modal fade" id="delete-teacher-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/teachers.deleteTeacher') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('users/teachers.deleteWarning') }}
                <form id="delete-form" action="{{ route('deleteTeacher') }}" method="POST">
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
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('users/teachers.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('users/teachers.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Selected Teachers -->
<div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/teachers.deleteSelectedTeachers') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-body">
                {{ trans('users/teachers.deleteWarning') }}
                <form id="delete-selected-form" action="{{ route('deleteSelectedTeachers') }}" method="POST">
                    @csrf
                    <input type="hidden" id="ids" name="ids" value="">
            </div>
            <hr style="margin: 0.1rem">
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('users/teachers.close') }}</button>
                <button type="submit" class="btn btn-danger">{{ trans('users/teachers.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

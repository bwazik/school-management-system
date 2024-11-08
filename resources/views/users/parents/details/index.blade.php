@extends('layouts.master')

@section('css')
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.parents') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.users') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.parents') }}
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#details" aria-controls="details" aria-selected="true">
                        <i class="menu-icon mdi mdi-card-account-details-outline me-1"></i> {{ trans('users/parents.details') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#attachments" aria-controls="attachments" aria-selected="false">
                        <i class="menu-icon mdi mdi-attachment me-1"></i> {{ trans('users/parents.step3Title') }}
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-success ms-1">{{ $attachmentsCount }}</span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content p-0 pt-4">
                <div class="tab-pane fade active show" id="details" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <tbody>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.email') }}</th>
                                    <td>{{ $parent -> email }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.password') }}</th>
                                    <td>············</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.father_name') }}</th>
                                    <td>{{ $parent -> father_name }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.mother_name') }}</th>
                                    <td>{{ $parent -> mother_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.father_national_id') }}</th>
                                    <td>{{ $parent -> father_national_id }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.mother_national_id') }}</th>
                                    <td>{{ $parent -> mother_national_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.father_passport_id') }}</th>
                                    <td>{{ $parent -> father_passport_id }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.mother_passport_id') }}</th>
                                    <td>{{ $parent -> mother_passport_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.father_phone') }}</th>
                                    <td>{{ $parent -> father_phone }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.mother_phone') }}</th>
                                    <td>{{ $parent -> mother_phone }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.job') }}</th>
                                    <td>{{ $parent -> father_job }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.job') }}</th>
                                    <td>{{ $parent -> mother_job }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.father_nationality') }}</th>
                                    <td>{{ $parent -> fatherNationality -> name }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.mother_nationality') }}</th>
                                    <td>{{ $parent -> motherNationality -> name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.father_blood_type') }}</th>
                                    <td>{{ $parent -> fatherBloodType -> name }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.mother_blood_type') }}</th>
                                    <td>{{ $parent -> motherBloodType -> name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.father_religion') }}</th>
                                    <td>{{ $parent -> fatherReligion -> name }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.mother_religion') }}</th>
                                    <td>{{ $parent -> motherReligion -> name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.address') }}</th>
                                    <td>{{ $parent -> father_address }}</td>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.address') }}</th>
                                    <td>{{ $parent -> mother_address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/parents.students') }}</th>
                                    <td>
                                        @if ($parent->students->isNotEmpty())
                                            @foreach ($parent->students as $student)
                                                <a href="{{ route('studentDetails', $student -> id) }}" target="_blank"><span class="badge bg-label-success mb-2">{{ $student->name }}</span></a>
                                                <br>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <th scope="row" class="table-secondary">-</th>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="attachments" role="tabpanel">
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <h5 class="alert-heading mb-2">{{ trans('users/parents.attachmentsAlertHead') }}</h5>
                        <p class="mb-0">
                            {{ trans('users/parents.attachmentsAlertP') }}
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('addParentAttachment', $parent -> id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" accept="image/jpg, image/jpeg, image/png" name="attachment" required>
                            <label class="input-group-text" for="attachment">[jpeg , jpg , png]</label>
                            @error('attachment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success d-block w-100 mt-2 waves-effect waves-light">{{ trans('users/parents.submit') }}</button>
                    </form>
                        <button data-bs-toggle="modal" data-bs-target="#delete-selected-modal" class="btn btn-danger d-block w-100 mt-2 waves-effect waves-light">{{ trans('users/parents.delete_all_attachments') }}</button>
                    <br><br>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('users/parents.file_name') }}</th>
                                    <th>{{ trans('users/parents.created_date') }}</th>
                                    <th>{{ trans('users/parents.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php $i=0; @endphp
                                @foreach ($attachments as $attachment)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $attachment -> file_name }}</td>
                                        <td>{{ $attachment -> created_at -> diffForHumans() }}</td>
                                        <td>
                                            <form id="show-form-{{ $attachment -> id }}" action="{{ url('parents/attachment/show/'. $parent -> father_national_id . '/' . $attachment -> file_name) }}" method="POST">@csrf</form>
                                            <form id="download-form-{{ $attachment -> id }}" action="{{ url('parents/attachment/download/'. $parent -> father_national_id . '/' . $attachment -> file_name) }}" method="POST">@csrf</form>
                                            <button onclick="event.preventDefault();document.getElementById('show-form-{{ $attachment -> id }}').submit();" class="btn btn-outline-warning btn-sm waves-effect me-1"><i class="ti ti-eye"></i></button>
                                            <button onclick="event.preventDefault();document.getElementById('download-form-{{ $attachment -> id }}').submit();" class="btn btn-outline-success btn-sm waves-effect me-1"><i class="ti ti-download"></i></button>
                                            <button data-bs-toggle="modal" data-bs-target="#delete-attachment-modal-{{ $attachment -> id }}" class="btn btn-outline-danger btn-sm waves-effect me-1"><i class="ti ti-trash"></i></button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="delete-attachment-modal-{{ $attachment -> id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/parents.delete_attachment') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                                <hr style="margin: 0.1rem">
                                                <div class="modal-body">
                                                    {{ trans('users/parents.deleteWarning') }}
                                                    <form id="delete-form" action="{{ url('parents/attachment/delete/'. $attachment -> id . '/' . $parent -> father_national_id . '/' . $attachment -> file_name) }}" method="POST">
                                                        @csrf
                                                </div>
                                                <hr style="margin: 0.1rem">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('users/parents.close') }}</button>
                                                    <button type="submit" class="btn btn-danger">{{ trans('users/parents.delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Selected Attachments -->
    <div class="modal fade" id="delete-selected-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/parents.delete_all_attachments') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <hr style="margin: 0.1rem">
                <div class="modal-body">
                    {{ trans('users/parents.deleteWarning') }}
                    <form id="delete-selected-form" action="{{ route('deleteAllParentAttachments', $parent -> id) }}" method="POST">
                        @csrf
                </div>
                <hr style="margin: 0.1rem">
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ trans('users/parents.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('users/parents.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        @if (Session::has('added'))
            toastr.success('{{ Session::get('added') }}');
        @endif
        @if (Session::has('count'))
            toastr.error('{{ Session::get('count') }}');
        @endif
        @if (Session::has('deleted'))
            toastr.success('{{ Session::get('deleted') }}');
        @endif
        @if (Session::has('deletedAll'))
            toastr.success('{{ Session::get('deletedAll') }}');
        @endif
    </script>
@endsection

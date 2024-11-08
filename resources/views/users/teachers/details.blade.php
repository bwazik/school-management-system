@extends('layouts.master')

@section('css')

@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.teachers') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.users') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.teachers') }}
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#details" aria-controls="details" aria-selected="true">
                        <i class="menu-icon mdi mdi-card-account-details-outline me-1"></i> {{ trans('users/teachers.details') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#attachments" aria-controls="attachments" aria-selected="false">
                        <i class="menu-icon mdi mdi-attachment me-1"></i> {{ trans('users/teachers.attachment') }}
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
                                    <td>{{ $teacher -> email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.password') }}</th>
                                    <td>············</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.name') }}</th>
                                    <td>{{ $teacher -> name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.subject') }}</th>
                                    <td>{{ $teacher -> subject -> name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.gender') }}</th>
                                    <td>{{ $teacher -> gender -> name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.joiningDate') }}</th>
                                    <td>{{ $teacher -> joining_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.classrooms') }}</th>
                                    <td>
                                        @if ($teacher -> classrooms -> isNotEmpty())
                                            @foreach ($teacher -> classrooms  as $classroom)
                                                    @php $label = "success"; @endphp
                                                    @if($classroom -> status == 0)
                                                        @php $label = "secondary"; @endphp
                                                    @endif
                                                <span class="badge bg-label-{{ $label }} mb-2">{{ $classroom -> stage -> name }} - {{ $classroom -> grade -> name }} - {{ $classroom -> name }}</span>
                                                <br>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="table-secondary">{{ trans('users/teachers.address') }}</th>
                                    <td>{{ $teacher -> address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="attachments" role="tabpanel">
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <h5 class="alert-heading mb-2">{{ trans('users/teachers.attachmentsAlertHead') }}</h5>
                        <p class="mb-0">
                            {{ trans('users/teachers.attachmentsAlertP') }}
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('addTeacherAttachment', $teacher -> id) }}" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-success d-block w-100 mt-2 waves-effect waves-light">{{ trans('users/teachers.submit') }}</button>
                    </form>
                        <button data-bs-toggle="modal" data-bs-target="#delete-selected-modal" class="btn btn-danger d-block w-100 mt-2 waves-effect waves-light">{{ trans('users/teachers.delete_all_attachments') }}</button>
                    <br><br>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('users/teachers.file_name') }}</th>
                                    <th>{{ trans('users/teachers.created_date') }}</th>
                                    <th>{{ trans('users/teachers.actions') }}</th>
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
                                            <form id="show-form-{{ $attachment -> id }}" action="{{ url('teachers/attachment/show/'. $teacher -> email . '/' . $attachment -> file_name) }}" method="POST">@csrf</form>
                                            <form id="download-form-{{ $attachment -> id }}" action="{{ url('teachers/attachment/download/'. $teacher -> email . '/' . $attachment -> file_name) }}" method="POST">@csrf</form>
                                            <button onclick="event.preventDefault();document.getElementById('show-form-{{ $attachment -> id }}').submit();" class="btn btn-outline-warning btn-sm waves-effect me-1"><i class="ti ti-eye"></i></button>
                                            <button onclick="event.preventDefault();document.getElementById('download-form-{{ $attachment -> id }}').submit();" class="btn btn-outline-success btn-sm waves-effect me-1"><i class="ti ti-download"></i></button>
                                            <button data-bs-toggle="modal" data-bs-target="#delete-attachment-modal-{{ $attachment -> id }}" class="btn btn-outline-danger btn-sm waves-effect me-1"><i class="ti ti-trash"></i></button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="delete-attachment-modal-{{ $attachment -> id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/teachers.delete_attachment') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                                <hr style="margin: 0.1rem">
                                                <div class="modal-body">
                                                    {{ trans('users/teachers.deleteWarning') }}
                                                    <form id="delete-form" action="{{ url('teachers/attachment/delete/'. $attachment -> id . '/' . $teacher -> email . '/' . $attachment -> file_name) }}" method="POST">
                                                        @csrf
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
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('users/teachers.delete_all_attachments') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <hr style="margin: 0.1rem">
                <div class="modal-body">
                    {{ trans('users/teachers.deleteWarning') }}
                    <form id="delete-selected-form" action="{{ route('deleteAllTeacherAttachments', $teacher -> id) }}" method="POST">
                        @csrf
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

<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-header card-header-bazoka flex-column flex-md-row">
            <div class="dt-action-buttons pt-3 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" wire:click="showAddForm">
                        <span>
                            <i class="ti ti-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('users/parents.addParent') }}</span>
                        </span>
                    </button>
                    <button class="btn btn-secondary btn-primary waves-effect waves-light me-2" tabindex="0" aria-controls="datatable" type="button" id="delete-selected-btn">
                        <span>
                            <i class="ti ti-trash me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ trans('users/parents.deletSelected') }}</span>
                        </span>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary waves-effect waves-light" data-bs-toggle="dropdown" tabindex="0" aria-controls="datatable" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-file-export me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ trans('users/parents.export') }}</span>
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
                    <th>{{ trans('users/parents.email') }}</th>
                    <th>{{ trans('users/parents.name') }}</th>
                    <th>{{ trans('users/parents.national_id') }}</th>
                    <th>{{ trans('users/parents.phone') }}</th>
                    <th>{{ trans('users/parents.job') }}</th>
                    <th>{{ trans('users/parents.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $i=0; @endphp
                @foreach ($parents as $parent)
                    @php $i++; @endphp
                    <tr class="odd">
                        <td class="sorting_1"><input type="checkbox" value="{{ $parent -> id }}" class="dt-checkboxes form-check-input box1"></td>
                        <td>{{ $i }}</td>
                        <td>{{ $parent -> email }}</td>
                        <td>{{ $parent -> father_name }}</td>
                        <td>{{ $parent -> father_national_id }}</td>
                        <td>{{ $parent -> father_phone }}</td>
                        <td>{{ $parent -> father_job }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a
                                        href="{{ route('parentDetails', $parent->id) }}" class="dropdown-item d-flex align-items-center">
                                        {{ trans('users/parents.detail') }}
                                    </a>
                                    <a
                                        href="{{ route('editParent', $parent->id) }}" class="dropdown-item d-flex align-items-center">
                                        {{ trans('users/parents.edit') }}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a
                                        id="delete-parent-button" data-bs-toggle="modal" data-bs-target="#delete-parent-modal"
                                        class="dropdown-item d-flex align-items-center text-danger" href="javascript:void(0);"
                                        data-id="{{ $parent->id }}" data-email="{{ $parent->email }}">
                                        {{ trans('users/parents.delete') }}
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('users.parents.modals')
    </div>
</div>

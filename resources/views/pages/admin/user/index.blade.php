@extends('layouts.base')

@section('header')
    <title>Admin | User</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data User
                    </h3>
                    <div class="my-2 mb-0 ms-3">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="dropdown-default-primary"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gear"></i>
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-default-primary">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-circle-plus"></i>
                                    Add New Data
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-filter"></i>
                                    Filter
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-file-export"></i>
                                    Export
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'class' => 'table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle',
                    ])
                    }}
                </div>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

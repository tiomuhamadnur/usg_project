@extends('layouts.base')

@section('header')
    <title>Admin | Registrasi</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Registrasi
                    </h3>
                    <div class="row my-2 ms-1 gx-1">
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <div class="btn-group w-100 w-md-auto">
                                <button type="button" class="btn btn-secondary dropdown-toggle w-100"
                                    id="dropdown-default-primary" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-gear"></i>
                                    Action
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end w-100 w-md-auto"
                                    aria-labelledby="dropdown-default-primary">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-filter"></i> Filter
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#exportModal">
                                            <i class="fa fa-file-export"></i> Export
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-auto">
                            <a href="{{ route('registrasi.create') }}" class="btn btn-primary w-100 w-md-auto">
                                <i class="fa fa-circle-plus"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'class' => 'table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle',
                    ]) }}
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

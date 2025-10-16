@extends('layouts.base')

@section('header')
    <title>Log Obat</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Log Obat
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
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#filterModal">
                                            <i class="fa fa-filter"></i> Filter
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-file-import"></i> Import
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-file-export"></i> Export
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-auto">
                            <a href="javascript:void(0)" class="btn btn-primary w-100 w-md-auto" data-bs-toggle="modal"
                                data-bs-target="#addModal">
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

@section('modals')
    <!-- Add Modal -->
    <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('log-obat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="tipe">Tipe Transaksi</label>
                            <select class="form-select" name="tipe" id="tipe" required>
                                <option value="" disabled selected>- pilih tipe transaksi -</option>
                                <option value="+">IN</option>
                                <option value="-">OUT</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="obat_id">Obat</label>
                            <select class="form-select" name="obat_id" id="obat_id" required>
                                <option value="" disabled selected>- pilih obat -</option>
                                @foreach ($obat as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sediaan->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="qty">Qty.</label>
                            <input type="number" min="1" class="form-control" name="qty" id="qty"
                                placeholder="Input jumlah transaksi" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="catatan">Catatan</label>
                            <textarea class="form-control" name="catatan" id="catatan" placeholder="input catatan transaksi (jika ada)" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa fa-plus"></i>
                            Create new
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Add Modal -->

    <!-- Filter Modal -->
    <div class="modal modal-blur fade" id="filterModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('log-obat.index') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    @method('GET')
                    <div class="modal-header">
                        <h5 class="modal-title">Filter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="dokter_id">Tanggal</label>
                            <div class="row align-items-center g-2">
                                <div class="col">
                                    <input class="form-control" type="date" name="start_date"
                                        value="{{ $start_date }}">
                                </div>
                                <div class="col-auto">
                                    <span class="form-text">s/d</span>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="date" name="end_date" value="{{ $end_date }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tipe">Tipe Transaksi</label>
                            <select class="form-select" name="tipe" id="tipe">
                                <option value="" selected disabled>- pilih tipe transaksi -</option>
                                <option value="+" @selected($tipe == '+')>IN</option>
                                <option value="-" @selected($tipe == '-')>OUT</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Batal
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('log-obat.index') }}" class="btn btn-danger">
                                <i class="fa fa-arrows-rotate"></i>
                                Reset
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i>
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Filter Modal -->
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

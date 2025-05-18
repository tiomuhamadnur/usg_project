@extends('layouts.base')

@section('header')
    <title>Registrasi</title>
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
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#filterModal">
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

@section('modals')
    <!-- Filter Modal -->
    <div class="modal modal-blur fade" id="filterModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('registrasi.index') }}" method="GET" enctype="multipart/form-data">
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
                            <label class="form-label" for="dokter_id">Dokter</label>
                            <select class="form-select" name="dokter_id" id="dokter_id">
                                <option value="" selected disabled>- pilih dokter -</option>
                                @foreach ($dokter as $item)
                                    <option value="{{ $item->id }}" @selected($item->id == $dokter_id)>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="room_id">Ruangan</label>
                            <select class="form-select" name="room_id" id="room_id">
                                <option value="" selected disabled>- pilih ruangan -</option>
                                @foreach ($room as $item)
                                    <option value="{{ $item->id }}" @selected($item->id == $room_id)>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status_pemeriksaan_id">Status Pemeriksaan</label>
                            <select class="form-select" name="status_pemeriksaan_id" id="status_pemeriksaan_id">
                                <option value="" selected disabled>- pilih status pemeriksaan -</option>
                                @foreach ($status_pemeriksaan as $item)
                                    <option value="{{ $item->id }}" @selected($item->id == $status_pemeriksaan_id)>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status_pembayaran_id">Status Pembayaran</label>
                            <select class="form-select" name="status_pembayaran_id" id="status_pembayaran_id">
                                <option value="" selected disabled>- pilih status pembayaran -</option>
                                @foreach ($status_pembayaran as $item)
                                    <option value="{{ $item->id }}" @selected($item->id == $status_pembayaran_id)>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Batal
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('registrasi.index') }}" class="btn btn-danger">
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

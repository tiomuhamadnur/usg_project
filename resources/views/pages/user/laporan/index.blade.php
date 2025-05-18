@extends('layouts.base')

@section('header')
    <title>Laporan</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Laporan
                    </h3>
                    <div class="my-2 mb-0 ms-3">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="dropdown-default-primary"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gear"></i>
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-default-primary">
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#filterModal">
                                    <i class="fa fa-filter"></i> Filter
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
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
                <form action="{{ route('laporan.index') }}" method="GET" enctype="multipart/form-data">
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
                            <label class="form-label" for="metode_pembayaran_id">Metode Bayar</label>
                            <select class="form-select" name="metode_pembayaran_id" id="metode_pembayaran_id">
                                <option value="" selected disabled>- pilih metode pembayaran -</option>
                                @foreach ($metode_pembayaran as $item)
                                    <option value="{{ $item->id }}" @selected($item->id == $metode_pembayaran_id)>
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
                            <a href="{{ route('laporan.index') }}" class="btn btn-danger">
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

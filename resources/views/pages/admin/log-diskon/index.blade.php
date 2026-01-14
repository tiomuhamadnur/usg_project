@extends('layouts.base')

@section('header')
    <title>Admin | Log Diskon</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Log Diskon
                    </h3>
                    <div class="my-2 mb-0 ms-3">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="dropdown-default-primary"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gear"></i>
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-default-primary">
                                {{-- <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="fa fa-circle-plus"></i>
                                    Add New Data
                                </a> --}}
                                <a class="dropdown-item" href="javascript:void(0)"  data-bs-toggle="modal"
                                    data-bs-target="#filterModal">
                                    <i class="fa fa-filter"></i>
                                    Filter
                                </a>
                                {{-- <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                    <i class="fa fa-file-export"></i>
                                    Export
                                </a> --}}
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

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('modals')
    <!-- Add Modal -->
    {{-- <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('diskon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Input name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="code">Code</label>
                            <input type="text" class="form-control" name="code" id="code"
                                placeholder="Input code" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" placeholder="Input deskripsi"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="harga">Nilai Diskon (Rp)</label>
                            <input type="number" class="form-control" name="harga" id="harga"
                                placeholder="Input harga" min="1" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="tanggal_awal">Tanggal awal berlaku</label>
                            <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal"
                                placeholder="Input tanggal awal" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="tanggal_akhir">Tanggal akhir berlaku</label>
                            <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir"
                                placeholder="Input tanggal akhir" autocomplete="off" required>
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
    </div> --}}
    <!-- END Add Modal -->

    <!-- Edit Modal -->
    {{-- <div class="modal modal-blur fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form id="editForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="name_edit">Name</label>
                            <input type="text" class="form-control" id="name_edit" name="name"
                                placeholder="Input name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="code_edit">Code</label>
                            <input type="text" class="form-control" name="code" id="code_edit"
                                placeholder="Input code" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="deskripsi_edit">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi_edit" rows="4" placeholder="Input deskripsi"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="harga_edit">Harga (Rp)</label>
                            <input type="number" class="form-control" name="harga" id="harga_edit"
                                placeholder="Input harga" min="1" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="tanggal_awal">Tanggal awal berlaku</label>
                            <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal_edit"
                                placeholder="Input tanggal awal" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="tanggal_akhir">Tanggal akhir berlaku</label>
                            <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir_edit"
                                placeholder="Input tanggal akhir" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa fa-pencil"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <!-- END Edit Modal -->

    <!-- Filter Modal -->
    <div class="modal modal-blur fade" id="filterModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('log-diskon.index') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    @method('GET')
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Filter</h5>
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
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Batal
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('log-diskon.index') }}" class="btn btn-secondary">
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

@section('javascript')
    {{-- <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                var name = $(e.relatedTarget).data('name');
                var code = $(e.relatedTarget).data('code');
                var harga = $(e.relatedTarget).data('harga');
                var deskripsi = $(e.relatedTarget).data('deskripsi');
                var tanggal_awal = $(e.relatedTarget).data('tanggal_awal');
                var tanggal_akhir = $(e.relatedTarget).data('tanggal_akhir');

                document.getElementById("editForm").action = url;
                $('#name_edit').val(name);
                $('#code_edit').val(code);
                $('#harga_edit').val(harga);
                $('#deskripsi_edit').val(deskripsi);
                $('#tanggal_awal_edit').val(tanggal_awal);
                $('#tanggal_akhir_edit').val(tanggal_akhir);
            });
        });
    </script> --}}
@endsection

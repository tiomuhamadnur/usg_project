@extends('layouts.base')

@section('header')
    <title>Admin | Obat</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Obat
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
                                    data-bs-target="#addModal">
                                    <i class="fa fa-circle-plus"></i>
                                    Add New Data
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-filter"></i>
                                    Filter
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

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('modals')
    <!-- Add Modal -->
    <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label class="form-label required" for="stock">Stock</label>
                            <input type="number" class="form-control" name="stock" id="stock"
                                placeholder="Input stock" min="0" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="unit_id">Unit</label>
                            <select class="form-select" name="unit_id" id="unit_id" required>
                                <option value="" disabled selected>- pilih unit -</option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->id }}">{{ $item->code }} ({{ $item->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="sediaan_id">Sediaan</label>
                            <select class="form-select" name="sediaan_id" id="sediaan_id" required>
                                <option value="" disabled selected>- pilih sediaan -</option>
                                @foreach ($sediaan as $item)
                                    <option value="{{ $item->id }}">{{ $item->code }} ({{ $item->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="harga_modal">Harga Modal (Rp)</label>
                            <input type="number" class="form-control" name="harga_modal" id="harga_modal"
                                placeholder="Input harga modal" min="1" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="harga_jual">Harga Jual (Rp)</label>
                            <input type="number" class="form-control" name="harga_jual" id="harga_jual"
                                placeholder="Input harga jual" min="1" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" id="merk"
                                placeholder="Input merk" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="bpom">BPOM</label>
                            <input type="text" class="form-control" name="bpom" id="bpom"
                                placeholder="Input bpom" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="kandungan">Kandungan</label>
                            <textarea class="form-control" name="kandungan" id="kandungan" rows="4" placeholder="Input kandungan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" placeholder="Input deskripsi"></textarea>
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

    <!-- Edit Modal -->
    <div class="modal modal-blur fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <input type="text" class="form-control" id="code_edit" name="code"
                                placeholder="Input code" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="stock">Stock</label>
                            <input type="number" class="form-control" name="stock" id="stock_edit"
                                placeholder="Input stock" min="0" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="unit_id">Unit</label>
                            <select class="form-select" name="unit_id" id="unit_id_edit" required>
                                <option value="" disabled selected>- pilih unit -</option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->id }}">{{ $item->code }} ({{ $item->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="sediaan_id">Sediaan</label>
                            <select class="form-select" name="sediaan_id" id="sediaan_id_edit" required>
                                <option value="" disabled selected>- pilih sediaan -</option>
                                @foreach ($sediaan as $item)
                                    <option value="{{ $item->id }}">{{ $item->code }} ({{ $item->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="harga_modal">Harga Modal (Rp)</label>
                            <input type="number" class="form-control" name="harga_modal" id="harga_modal_edit"
                                placeholder="Input harga modal" min="1" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="harga_jual">Harga Jual (Rp)</label>
                            <input type="number" class="form-control" name="harga_jual" id="harga_jual_edit"
                                placeholder="Input harga jual" min="1" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" id="merk_edit"
                                placeholder="Input merk" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="bpom">BPOM</label>
                            <input type="text" class="form-control" name="bpom" id="bpom_edit"
                                placeholder="Input bpom" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="kandungan">Kandungan</label>
                            <textarea class="form-control" name="kandungan" id="kandungan_edit" rows="4" placeholder="Input kandungan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi_edit" rows="4" placeholder="Input deskripsi"></textarea>
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
    </div>
    <!-- END Edit Modal -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                var name = $(e.relatedTarget).data('name');
                var code = $(e.relatedTarget).data('code');
                var stock = $(e.relatedTarget).data('stock');
                var unit_id = $(e.relatedTarget).data('unit_id');
                var sediaan_id = $(e.relatedTarget).data('sediaan_id');
                var harga_modal = $(e.relatedTarget).data('harga_modal');
                var harga_jual = $(e.relatedTarget).data('harga_jual');
                var merk = $(e.relatedTarget).data('merk');
                var bpom = $(e.relatedTarget).data('bpom');
                var kandungan = $(e.relatedTarget).data('kandungan');
                var deskripsi = $(e.relatedTarget).data('deskripsi');

                document.getElementById("editForm").action = url;
                $('#name_edit').val(name);
                $('#code_edit').val(code);
                $('#stock_edit').val(stock);
                $('#unit_id_edit').val(unit_id);
                $('#sediaan_id_edit').val(sediaan_id);
                $('#harga_modal_edit').val(harga_modal);
                $('#harga_jual_edit').val(harga_jual);
                $('#merk_edit').val(merk);
                $('#bpom_edit').val(bpom);
                $('#kandungan_edit').val(kandungan);
                $('#deskripsi_edit').val(deskripsi);
            });
        });
    </script>
@endsection

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
                        Ubah Data User
                    </h3>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Grid with Labels -->
                        <form action="{{ route('user.update', $user->uuid) }}" id="formAdd" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row mb-4">
                                <div class="col-12 col-md-3">
                                    <label class="form-label optional">Gelar Depan</label>
                                    <input type="text" class="form-control" name="gelar_depan" id="gelar_depan"
                                        value="{{ old('gelar_depan', $user->gelar_depan ?? '') }}"
                                        placeholder="input gelar depan" autocomplete="off">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $user->name ?? '') }}"
                                        placeholder="input nama lengkap" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label optional">Gelar Belakang</label>
                                    <input type="text" class="form-control" name="gelar_belakang" id="gelar_belakang"
                                        value="{{ old('gelar_belakang', $user->gelar_belakang ?? '') }}"
                                        placeholder="input gelar belakang" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">No. HP/WA</label>
                                    <input type="tel" class="form-control" name="no_hp" id="no_hp"
                                        value="{{ old('no_hp', $user->no_hp ?? '') }}"
                                        placeholder="contoh: 08xxxxxxxxxx" pattern="^(\+62|62|0)8[1-9][0-9]{6,9}$"
                                        required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Email</label>
                                    <input type="email" class="form-control"
                                        placeholder="input email" value="{{ old('email', $user->email ?? '') }}"
                                        autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Jenis Kelamin</label>
                                    <select class="form-select js-select2" name="gender_id" id="gender_id" required>
                                        <option value="" selected disabled>- pilih jenis kelamin -</option>
                                        @foreach ($gender as $item)
                                            <option value="{{ $item->id }}" @selected(old('gender_id', $user->gender_id) == $item->id)>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Role</label>
                                    <select class="form-select" name="role_id" id="role_id" required>
                                        <option value="" selected disabled>- pilih role -</option>
                                        @foreach ($role as $item)
                                            <option value="{{ $item->id }}" @selected(old('role_id', $user->role_id) == $item->id)>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!-- END Form Grid with Labels -->
                    </div>
                </div>
            </div>
            <div class="block-header block-header-default d-flex justify-content-end">
                <a href="{{ route('user.index') }}" class="btn btn-lg btn-danger my-3 me-2">
                    <i class="fa fa-arror-left"></i>
                    Batal
                </a>
                <button type="submit" form="formAdd" class="btn btn-lg btn-primary my-3">
                    <i class="fa fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('javascript')
@endsection

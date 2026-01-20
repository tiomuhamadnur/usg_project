@extends('layouts.base')

@section('header')
    <title>Profile</title>
@endsection

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="fs-3 fw-semibold mb-0">
                    Profile Pengguna
                </h3>
            </div>

            <div class="block-content block-content-full">
                <form action="{{ route('profile.update', $user->uuid) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- FOTO PROFILE --}}
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('media/avatars/profile.png') }}"
                                    class="img-avatar img-avatar96 img-avatar-thumb" alt="Foto Profile">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Profile</label>
                                <input type="file" name="photo" class="form-control" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">JPG / JPEG / PNG, max 2MB</small>
                            </div>
                        </div>

                        {{-- DATA PROFILE --}}
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->name }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control"
                                        value="{{ $user->email }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No. HP</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->no_hp }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" value="{{ $user->role->name ?? '-' }}"
                                        disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="{{ $user->roles->first()->name ?? '-' }}"
                                        disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->isBanned() ? 'Non Aktif' : 'Aktif' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- UBAH PASSWORD --}}
                    <h5 class="fw-semibold mb-3">Ubah Password</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="old_password" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

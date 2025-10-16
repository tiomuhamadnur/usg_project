@extends('layouts.base')

@section('header')
    <title>Dashboard</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Home -->
        @Admin
            <div class="row">
                <div class="col-md-12">
                    <div class="block block-rounded block-link-shadow card">
                        {{-- Header --}}
                        <div class="block-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h2 class="fs-3 fw-semibold my-2 mb-0">
                                {{-- 👋 Halo, {{ auth()->user()->name ?? 'Admin' }}! --}}
                                📝 Registrasi
                            </h2>
                        </div>

                        {{-- Content --}}
                        <div class="block-content block-content-full">
                            <div class="row g-4">
                                {{-- Pasien Lama --}}
                                <div class="col-md-6">
                                    <a href="{{ route('registrasi.create') }}"
                                        class="block block-rounded block-link-shadow text-center h-100 btn btn-outline-primary">
                                        <div class="block-content block-content-full py-4">
                                            <div class="item item-circle bg-light mx-auto mb-3">
                                                <i class="fa fa-user fs-2 text-primary"></i>
                                            </div>
                                            <p class="fs-5 fw-semibold text-dark mb-1">Pasien Lama</p>
                                            <p class="text-muted small mb-0">Registrasi ulang pasien terdaftar</p>
                                        </div>
                                    </a>
                                </div>

                                {{-- Pasien Baru --}}
                                <div class="col-md-6">
                                    <a href="{{ route('pasien.create') }}"
                                        class="block block-rounded block-link-shadow text-center h-100 btn btn-outline-success">
                                        <div class="block-content block-content-full py-4">
                                            <div class="item item-circle bg-light mx-auto mb-3">
                                                <i class="fa fa-user-plus fs-2 text-success"></i>
                                            </div>
                                            <p class="fs-5 fw-semibold text-dark mb-1">Pasien Baru</p>
                                            <p class="text-muted small mb-0">Registrasi pasien baru</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="block block-rounded block-link-shadow card">
                        {{-- Header --}}
                        <div
                            class="block-header block-header-default bg-primary text-white d-flex justify-content-between align-items-center">
                            <h3 class="fs-3 fw-semibold my-2 mb-0">
                                {{-- 👨‍⚕️ Halo, {{ auth()->user()->name ?? 'Dokter' }}! --}}
                                🩺 Pemeriksaan Awal
                            </h3>
                        </div>

                        {{-- Content --}}
                        <div class="block-content block-content-full">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8 col-lg-8">
                                    <form action="{{ route('pemeriksaan-awal.create') }}" method="GET">
                                        <div class="py-4">
                                            <label for="code" class="form-label fw-semibold">🔎 Cari Pasien</label>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text bg-light">
                                                    <i class="fa fa-user-injured text-primary"></i>
                                                </span>
                                                <input type="text" class="form-control" name="code" id="code"
                                                    placeholder="Masukkan No. Registrasi (ex: REG-123)" autofocus required
                                                    autocomplete="off">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-search"></i> Cari
                                                </button>
                                            </div>
                                            <small class="text-muted">
                                                Bisa menggunakan nomor registrasi atau scan barcode pasien.
                                            </small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="block block-rounded block-link-shadow card">
                        {{-- Header --}}
                        <div
                            class="block-header block-header-default bg-primary text-white d-flex justify-content-between align-items-center">
                            <h3 class="fs-3 fw-semibold my-2 mb-0">
                                {{-- 👨‍⚕️ Halo, {{ auth()->user()->name ?? 'Dokter' }}! --}}
                                💰 Kasir
                            </h3>
                        </div>

                        {{-- Content --}}
                        <div class="block-content block-content-full">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8 col-lg-8">
                                    <form action="{{ route('kasir.create') }}" method="GET">
                                        <div class="py-4">
                                            <label for="code" class="form-label fw-semibold">🔎 Cari Pasien</label>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text bg-light">
                                                    <i class="fa fa-user-injured text-primary"></i>
                                                </span>
                                                <input type="text" class="form-control" name="code" id="code"
                                                    placeholder="Masukkan No. Registrasi (ex: REG-123)" autofocus required
                                                    autocomplete="off">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-search"></i> Cari
                                                </button>
                                            </div>
                                            <small class="text-muted">
                                                Bisa menggunakan nomor registrasi atau scan barcode pasien.
                                            </small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endAdmin


        @Dokter
            <div class="row">
                <div class="col-md-12">
                    <div class="block block-rounded block-link-shadow card">
                        {{-- Header --}}
                        <div
                            class="block-header block-header-default bg-primary text-white d-flex justify-content-between align-items-center">
                            <h3 class="fs-3 fw-semibold my-2 mb-0">
                                {{-- 👨‍⚕️ Halo, {{ auth()->user()->name ?? 'Dokter' }}! --}}
                                👨‍⚕️ Pemeriksaan Dokter
                            </h3>
                        </div>

                        {{-- Content --}}
                        <div class="block-content block-content-full">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8 col-lg-8">
                                    <form action="{{ route('pemeriksaan-dokter.create') }}" method="GET">
                                        <div class="py-4">
                                            <label for="code" class="form-label fw-semibold">🔎 Cari Pasien</label>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text bg-light">
                                                    <i class="fa fa-user-injured text-primary"></i>
                                                </span>
                                                <input type="text" class="form-control" name="code" id="code"
                                                    placeholder="Masukkan No. Registrasi (ex: REG-123)" autofocus required
                                                    autocomplete="off">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-search"></i> Cari
                                                </button>
                                            </div>
                                            <small class="text-muted">
                                                Bisa menggunakan nomor registrasi atau scan barcode pasien.
                                            </small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endDokter

        <!-- END Home -->
    </div>
    <!-- END Page Content -->
@endsection

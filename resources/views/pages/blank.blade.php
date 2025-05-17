@extends('layouts.base')

@section('header')
    <title>Unassigned User</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title fw-bolder">
                    <span class="text-danger">
                        <i class="fa fa-circle-xmark"></i>
                    </span>
                    Ooopss!
                </h3>
            </div>
            <div class="block-content">
                <p>Akun anda <span class="fw-bolder">{{ auth()->user()->email }}</span> belum diaktivasi, silahkan hubungi Admin.</p>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection

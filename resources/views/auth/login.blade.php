@extends('auth.layouts.base')

@section('header')
    <title>Admin | Kasir</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="bg-image" style="background-image: url('{{ asset('media/photos/photo19@2x.jpg') }}');">
        <div class="row g-0 justify-content-center bg-primary-dark-op">
            <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                <!-- Sign In Block -->
                <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                    <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                        <!-- Header -->
                        <div class="mb-2 text-center">
                            <a class="link-fx fw-bold fs-1" href="{{ route('dashboard.index') }}">
                                <span class="text-dark">USG</span><span class="text-primary">aja</span>
                            </a>
                            <p class="text-uppercase fw-bold fs-sm text-muted">Sign In</p>
                        </div>
                        <!-- END Header -->

                        <!-- Sign In Form -->
                        <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
                            @method('POST')
                            @csrf
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                </div>
                                @error('email')
                                    <span class="text-xs text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        required autocomplete="current-password" id="password" name="password"
                                        placeholder="Password">
                                    <span class="input-group-text">
                                        <i class="fa fa-asterisk"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="text-xs text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div
                                class="d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-start mb-4">
                                <div class="fw-semibold fs-sm py-1">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-hero btn-primary">
                                    <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Sign In
                                </button>
                            </div>
                        </form>
                        <!-- END Sign In Form -->
                    </div>
                    <div class="block-content bg-body">
                        <div class="d-flex justify-content-center text-center push">
                            <div class="col-sm-12 order-sm-2 mb-1 mb-sm-0 text-center">
                                Crafted with <i class="fa fa-heart text-danger"></i> by <a
                                    href="https://instagram.com/tyomuhamadnur" class="fw-semibold" target="_blank">Tio
                                    Muhamad Nur</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Sign In Block -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection

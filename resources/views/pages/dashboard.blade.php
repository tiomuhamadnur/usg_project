@extends('layouts.base')

@section('header')
    <title>Dashboard</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Dashboard -->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fa fa-2x fa-arrow-up text-primary"></i>
                        </div>
                        <div class="ms-3 text-end">
                            <p class="fs-3 fw-medium mb-0">
                                + 30%
                            </p>
                            <p class="text-muted mb-0">
                                Earnings
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="far fa-2x fa-user-circle text-success"></i>
                        </div>
                        <div class="ms-3 text-end">
                            <p class="fs-3 fw-medium mb-0">
                                +78%
                            </p>
                            <p class="text-muted mb-0">
                                Users
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <p class="fs-3 fw-medium mb-0">
                                960
                            </p>
                            <p class="text-muted mb-0">
                                Sales
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-2x fa-chart-area text-danger"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <p class="fs-3 fw-medium mb-0">
                                359
                            </p>
                            <p class="text-muted mb-0">
                                Projects
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-2x fa-box text-warning"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-shadow bg-primary" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fa fa-2x fa-arrow-alt-circle-up text-primary-lighter"></i>
                        </div>
                        <div class="ms-3 text-end">
                            <p class="text-white fs-3 fw-medium mb-0">
                                + 45%
                            </p>
                            <p class="text-white-75 mb-0">
                                Earnings
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-shadow bg-success" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="far fa-2x fa-user text-success-light"></i>
                        </div>
                        <div class="ms-3 text-end">
                            <p class="text-white fs-3 fw-medium mb-0">
                                +98%
                            </p>
                            <p class="text-white-75 mb-0">
                                Users
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-shadow bg-danger" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <p class="text-white fs-3 fw-medium mb-0">
                                450
                            </p>
                            <p class="text-white-75 mb-0">
                                Sales
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-2x fa-chart-line text-black-50"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-shadow bg-warning" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <p class="text-white fs-3 fw-medium mb-0">
                                63
                            </p>
                            <p class="text-white-75 mb-0">
                                Projects
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-2x fa-boxes text-black-50"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="row text-center">
                            <div class="col-4 border-end">
                                <div class="py-3">
                                    <div class="item item-circle bg-body-light mx-auto">
                                        <i class="fa fa-briefcase text-primary"></i>
                                    </div>
                                    <p class="fs-3 fw-medium mt-3 mb-0">
                                        61
                                    </p>
                                    <p class="text-muted mb-0">
                                        Projects
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 border-end">
                                <div class="py-3">
                                    <div class="item item-circle bg-body-light mx-auto">
                                        <i class="fa fa-chart-line text-primary"></i>
                                    </div>
                                    <p class="fs-3 fw-medium mt-3 mb-0">
                                        50
                                    </p>
                                    <p class="text-muted mb-0">
                                        Sales
                                    </p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="py-3">
                                    <div class="item item-circle bg-body-light mx-auto">
                                        <i class="fa fa-users text-primary"></i>
                                    </div>
                                    <p class="fs-3 fw-medium mt-3 mb-0">
                                        15
                                    </p>
                                    <p class="text-muted mb-0">
                                        Clients
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="block block-rounded bg-gd-sublime" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="row text-center">
                            <div class="col-4 border-end border-black-op">
                                <div class="py-3">
                                    <div class="item item-circle bg-black-25 mx-auto">
                                        <i class="fa fa-briefcase text-white"></i>
                                    </div>
                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                        61
                                    </p>
                                    <p class="text-white-75 mb-0">
                                        Projects
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 border-end border-black-op">
                                <div class="py-3">
                                    <div class="item item-circle bg-black-25 mx-auto">
                                        <i class="fa fa-chart-line text-white"></i>
                                    </div>
                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                        50
                                    </p>
                                    <p class="text-white-75 mb-0">
                                        Sales
                                    </p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="py-3">
                                    <div class="item item-circle bg-black-25 mx-auto">
                                        <i class="fa fa-users text-white"></i>
                                    </div>
                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                        15
                                    </p>
                                    <p class="text-white-75 mb-0">
                                        Clients
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Dashboard -->
    </div>
    <!-- END Page Content -->
@endsection

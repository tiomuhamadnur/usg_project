<!-- Side Overlay-->
<aside id="side-overlay">
    <!-- Side Header -->
    <div class="bg-image"
        style="background-image: url('{{ asset('media/various/bg_side_overlay_header.jpg') }}');">
        <div class="bg-primary-op">
            <div class="content-header">
                <!-- User Avatar -->
                <a class="img-link me-1" href="javascript:void(0)">
                    <img class="img-avatar img-avatar48" src="{{ asset('media/avatars/avatar10.jpg') }}"
                        alt="">
                </a>
                <!-- END User Avatar -->

                <!-- User Info -->
                <div class="ms-2">
                    <a class="text-white fw-semibold" href="javascript:void(0)">Tio Muhamad Nur</a>
                    <div class="text-white-75 fs-sm">Full Stack Developer</div>
                </div>
                <!-- END User Info -->

                <!-- Close Side Overlay -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="ms-auto text-white" href="javascript:void(0)" data-toggle="layout"
                    data-action="side_overlay_close">
                    <i class="fa fa-times-circle"></i>
                </a>
                <!-- END Close Side Overlay -->
            </div>
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side">
        <div class="block pull-x mb-0">
            <!-- Sidebar -->
            <div class="block-content block-content-sm block-content-full bg-body">
                <span class="text-uppercase fs-sm fw-bold">Sidebar</span>
            </div>
            <div class="block-content block-content-full">
                <div class="row g-sm text-center">
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="sidebar_style_dark" href="javascript:void(0)">Dark</a>
                    </div>
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="sidebar_style_light" href="javascript:void(0)">Light</a>
                    </div>
                </div>
            </div>
            <!-- END Sidebar -->

            <!-- Header -->
            <div class="block-content block-content-sm block-content-full bg-body">
                <span class="text-uppercase fs-sm fw-bold">Header</span>
            </div>
            <div class="block-content block-content-full">
                <div class="row g-sm text-center mb-2">
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="header_style_dark" href="javascript:void(0)">Dark</a>
                    </div>
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="header_style_light" href="javascript:void(0)">Light</a>
                    </div>
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="header_mode_fixed" href="javascript:void(0)">Fixed</a>
                    </div>
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="header_mode_static" href="javascript:void(0)">Static</a>
                    </div>
                </div>
            </div>
            <!-- END Header -->

            <!-- Content -->
            <div class="block-content block-content-sm block-content-full bg-body">
                <span class="text-uppercase fs-sm fw-bold">Content</span>
            </div>
            <div class="block-content block-content-full">
                <div class="row g-sm text-center">
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="content_layout_boxed" href="javascript:void(0)">Boxed</a>
                    </div>
                    <div class="col-6 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="content_layout_narrow" href="javascript:void(0)">Narrow</a>
                    </div>
                    <div class="col-12 mb-1">
                        <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
                            data-action="content_layout_full_width" href="javascript:void(0)">Full Width</a>
                    </div>
                </div>
            </div>
            <!-- END Content -->
        </div>
        <div class="block pull-x mb-0">
            <!-- Content -->
            <div class="block-content block-content-sm block-content-full bg-body">
                <span class="text-uppercase fs-sm fw-bold">Heading</span>
            </div>
            <div class="block-content">
                <p>
                    Content..
                </p>
            </div>
            <!-- END Content -->
        </div>
    </div>
    <!-- END Side Content -->
</aside>
<!-- END Side Overlay -->

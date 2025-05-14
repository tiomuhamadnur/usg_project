@extends('layouts.base')

@section('header')
    <title>Admin | Pemeriksaan Pasien</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Pemeriksaan Pasien
                    </h3>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row border border-2">
                    <div class="col-lg-12">
                        <!-- Block Tabs Animated Slide Up -->
                        <div class="block block-rounded">
                            <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="btabs-animated-slideup-home-tab"
                                        data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-home" role="tab"
                                        aria-controls="btabs-animated-slideup-home" aria-selected="true">Admin</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="btabs-animated-slideup-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#btabs-animated-slideup-profile" role="tab"
                                        aria-controls="btabs-animated-slideup-profile" aria-selected="false">Dokter</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="btabs-animated-slideup-kasir-tab" data-bs-toggle="tab"
                                        data-bs-target="#btabs-animated-slideup-kasir" role="tab"
                                        aria-controls="btabs-animated-slideup-kasir" aria-selected="false">Kasir</button>
                                </li>
                            </ul>
                            <div class="block-content tab-content overflow-hidden">
                                <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home"
                                    role="tabpanel" aria-labelledby="btabs-animated-slideup-home-tab" tabindex="0">
                                    <h4 class="fw-normal">Admin Content</h4>
                                    <p>Content slides up..</p>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" form="formAdmin" class="btn btn-lg btn-primary">
                                            <i class="fa fa-floppy-disk"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile" role="tabpanel"
                                    aria-labelledby="btabs-animated-slideup-profile-tab" tabindex="0">
                                    <h4 class="fw-normal">Dokter Content</h4>
                                    <p>Content slides up..</p>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" form="formDokter" class="btn btn-lg btn-primary">
                                            <i class="fa fa-floppy-disk"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade fade-up" id="btabs-animated-slideup-kasir" role="tabpanel"
                                    aria-labelledby="btabs-animated-slideup-kasir-tab" tabindex="0">
                                    <h4 class="fw-normal">Kasir Content</h4>
                                    <p>Content slides up..</p>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" form="formKasir" class="btn btn-lg btn-primary">
                                            <i class="fa fa-floppy-disk"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Block Tabs Animated Slide Up -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            // Copy data identitas dari Pasien ke PJ
            function copyIdentitasKePJ(dariPasien) {
                console.log('copyIdentitasKePJ called, dariPasien =', dariPasien);
                if (dariPasien) {
                    const pasien_name = $('#name').val();
                    const pasien_gender_id = $('#gender_id').val();
                    const pasien_nik = $('#nik').val();
                    const pasien_no_hp = $('#no_hp').val();

                    console.log('pasien_name:', pasien_name);
                    console.log('pasien_gender_id:', pasien_gender_id);
                    console.log('pasien_nik:', pasien_nik);
                    console.log('pasien_no_hp:', pasien_no_hp);

                    $('#pj_name').val(pasien_name);
                    $('#pj_gender_id').val(pasien_gender_id).trigger('change');
                    $('#pj_nik').val(pasien_nik);
                    $('#pj_no_hp').val(pasien_no_hp);

                    console.log('SET pj_name:', $('#pj_name').val());
                    console.log('SET pj_gender_id:', $('#pj_gender_id').val());
                    console.log('SET pj_nik:', $('#pj_nik').val());
                    console.log('SET pj_no_hp:', $('#pj_no_hp').val());
                } else {
                    $('#pj_name').val('');
                    $('#pj_gender_id').val('').trigger('change');
                    $('#pj_nik').val('');
                    $('#pj_no_hp').val('');

                    console.log('RESET semua field PJ jadi kosong');
                }
            }

            // Event ketika hubungan_pasien_id berubah
            $('#hubungan_pasien_id').on('change', function() {
                const nilai = $(this).val();
                console.log('hubungan_pasien_id changed, value =', nilai);
                if (nilai == '1') {
                    copyIdentitasKePJ(true);
                } else {
                    copyIdentitasKePJ(false);
                }
            });

            // Fungsi utama copy alamat PJ berurutan
            $('input[name="isSame"]').on('change', function() {
                const nilai = $('input[name="isSame"]:checked').val();
                console.log('isSame changed, value =', nilai);

                const alamatPasien = $('#alamat').val();
                console.log('alamat pasien:', alamatPasien);

                if (nilai == '1') {
                    $('#pj_alamat').val(alamatPasien);
                    console.log('SET pj_alamat:', alamatPasien);
                } else {
                    $('#pj_alamat').val('');
                    console.log('RESET pj_alamat kosong');
                }
            });
        });
    </script>
@endsection

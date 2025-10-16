<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Struk Registrasi - {{ $pemeriksaan->code }}</title>
        <style>
            @page {
                size: 58mm auto;
                margin: 0 !important;
            }

            html,
            body {
                margin: 0;
                padding: 0;
                font-family: monospace;
                font-size: 12px;
                background: #f5f5f5;
                /* biar kelihatan centernya saat preview */
                height: 100%;
            }

            .preview-wrapper {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                /* kalau mau pas di atas */
                min-height: 100vh;
                padding: 10px;
            }

            .logo {
                display: block;
                margin: 0 auto 6px auto;
                height: 45px;
                /* tinggi konsisten */
                width: auto;
                /* proporsional */
            }

            .receipt {
                width: 58mm;
                background: #fff;
                padding: 4px;
                outline: 1px dashed #aaa;
                /* panduan batas kertas */
            }

            .text-center {
                text-align: center;
            }

            .line {
                border-top: 1px dashed #000;
                margin: 6px 0;
            }

            h1 {
                font-size: 32px;
                margin: 8px 0;
            }

            .barcode-container {
                margin: 10px 0;
                text-align: center;
            }

            .barcode-container img {
                display: block;
                width: 100%;
                height: 40px;
                max-height: 40px;
                object-fit: fill;
                image-rendering: pixelated;
            }

            .barcode-text {
                font-size: 14px;
                letter-spacing: 1px;
                margin-top: 4px;
            }

            .small-text {
                font-size: 10px;
            }

            @media print {
                body {
                    font-size: 10px !important;
                    /* kecilkan saat print */
                    background: #fff !important;
                    /* buang background abu */
                }

                h1 {
                    font-size: 24px !important;
                    /* supaya antrian tidak terlalu gede */
                }

                .barcode-text {
                    font-size: 12px !important;
                }

                .receipt {
                    outline: none !important;
                    /* buang outline abu */
                }

                .preview-wrapper {
                    padding: 0 !important;
                    /* biar pas kertas */
                }
            }
        </style>
    </head>

    <body>
        <div class="preview-wrapper">
            <div class="receipt">
                <!-- isi struk tetap sama -->
                <div class="text-center">
                    <img class="logo" src="{{ asset('media/favicons/logo_horizontal.png') }}" alt="Logo Klinik">
                    {{-- <strong>KLINIK USG AJA</strong><br> --}}
                    <span>by dr. Naya</span><br>
                    <span class="small-text">Jl. Taman Cimanggu Tengah No.11</span><br>
                    <span class="small-text">Telp: 0895-0894-7548</span>
                </div>

                <div class="line"></div>

                <div>
                    <div><strong>Tanggal:</strong> {{ $pemeriksaan->datetime_registrasi }}</div>
                    <div><strong>Dokter:</strong> {{ $pemeriksaan->dokter->name ?? 'N/A' }}</div>
                </div>

                <div class="line"></div>

                <div class="text-center">
                    <strong>Pasien</strong>
                    <div class="barcode-container">
                        <img src="{{ $pasien_barcode_base64 }}" alt="Barcode Pasien">
                        <div class="barcode-text"><strong>{{ $pemeriksaan->pasien->name ?? 'N/A' }}</strong></div>
                    </div>
                </div>

                <div class="line"></div>

                <div class="text-center">
                    <strong>No. Antrean</strong>
                    <h1>{{ $pemeriksaan->no_urut }}</h1>
                </div>

                <div class="line"></div>

                <div class="text-center">
                    <strong>No. Registrasi</strong>
                    <div class="barcode-container">
                        <img src="{{ $registrasi_barcode_base64 }}" alt="Barcode Registrasi">
                        <div class="barcode-text"><strong>{{ $pemeriksaan->code ?? 'N/A' }}</strong></div>
                    </div>
                </div>

                <div class="line"></div>

                <div class="text-center small-text">
                    *** Terima Kasih ***<br>
                    Simpan struk ini untuk keperluan administrasi
                </div>
            </div>
        </div>

        <script>
            window.onload = () => window.print();
        </script>
    </body>

</html>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Print Registrasi Pasien</title>
        <style>
            @media print {
                @page {
                    size: 58mm auto;
                    margin: 0;
                }

                body {
                    font-family: monospace;
                    font-size: 12px;
                    width: 58mm;
                    margin: 0;
                }

                .receipt {
                    padding: 10px;
                }

                button {
                    display: none;
                }
            }

            body {
                font-family: monospace;
                font-size: 12px;
                width: 58mm;
                margin: auto;
            }

            h1 {
                margin-top: 2px;
                margin-bottom: 2px;
            }

            .receipt {
                padding: 10px;
                border: 1px dashed #ccc;
            }

            .line {
                border-top: 1px dashed #000;
                margin: 5px 0;
            }

            .text-center {
                text-align: center;
                margin-top: 4px;
                margin-bottom: 4px;
            }

            .text-right {
                text-align: right;
            }

            .text-left {
                text-align: left;
            }

            .item {
                display: flex;
                justify-content: space-between;
            }

            .qrcode {
                border: 1px solid #000;
                border-radius: 8px;
                margin: 10px auto;
                padding: 5px;
                display: inline-block;
            }

            .barcode-container {
                margin-top: 2px;
            }

            .barcode-text {
                margin-top: 0px;
                font-size: 14px;
                letter-spacing: 1px;
            }

            p {
                margin-top: 0px;
                margin-bottom: 0px;
                font-size: 10px;
                letter-spacing: 1px;
            }

            .small-text {
                font-size: 8px;
            }

            .disctance-vertical {
                margin-top: 15px;
                margin-bottom: 15px;
            }
        </style>
        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
    </head>

    <body>
        <div class="receipt">
            <div class="text-center">
                <strong>KLINIK USG AJA</strong>
                <p>by dr. Naya</p>
                <p class="small-text">Jl. Taman Cimanggu Tengah No.11</p>
                <p class="small-text">0895-0894-7548</p>
            </div>

            <div class="line"></div>

            <div class="item">
                <strong>No. Antrean:</strong>
            </div>
            <div class="text-center">
                <h1>{{ $pemeriksaan->no_urut }}</h1>
            </div>

            <div class="line"></div>

            <div class="item">
                <span>Tanggal:</span>
                <span>{{ $pemeriksaan->datetime }}</span>
            </div>
            <div class="item">
                <span>Dokter:</span>
                <span>{{ $pemeriksaan->dokter->gelar_depan ?? 'N/A' }} {{ $pemeriksaan->dokter->name ?? 'N/A' }}
                    {{ $pemeriksaan->dokter->gelar_belakang ?? 'N/A' }}</span>
            </div>
            {{-- <div class="item">
                <span>Ruangan:</span>
                <span>{{ $pemeriksaan->room->name ?? 'N/A' }}</span>
            </div> --}}

            <div class="line"></div>

            <div class="item">
                <strong>Kode Registrasi:</strong>
            </div>
            <div class="text-center">
                <div class="barcode-container">
                    <img style="width: 80%;" src="{{ $registrasi_barcode_base64 }}" alt="Barcode">
                    <div class="barcode-text">
                        {{ $pemeriksaan->code ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="line disctance-vertical"></div>

            <div class="item">
                <strong>Data Pasien:</strong>
            </div>
            <div class="text-center">
                <div class="barcode-container">
                    <img style="width: 90%;" src="{{ $pasien_barcode_base64 }}" alt="Barcode">
                    <div class="barcode-text">
                        {{ $pemeriksaan->pasien->name ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="text-center">
                *** Terima Kasih ***<br>
            </div>
        </div>

        <script>
            window.onload = function() {
                window.print();
            }
        </script>
    </body>

</html>

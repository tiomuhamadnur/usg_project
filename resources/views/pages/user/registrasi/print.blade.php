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
    </style>
</head>

<body>
    <div class="receipt">
        <div class="text-center">
            <strong>KLINIK USG AJA</strong><br>
            by dr. Naya<br>
            Jl. Taman Cimanggu Tengah No.11<br>
            0895-0894-7548<br>
            -----------------------------
        </div>
        <div class="text-left">
            <span>No. Antrean:</span>
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
            <span>Nama Pasien:</span>
            <span>{{ $pemeriksaan->pasien->name }}</span>
        </div>
        <div class="item">
            <span>Dokter:</span>
            <span>{{ $pemeriksaan->dokter->name }}</span>
        </div>
        <div class="item">
            <span>Ruangan:</span>
            <span>{{ $pemeriksaan->room->name }}</span>
        </div>

        <div class="line"></div>

        <div class="item">
            <strong>Kode Registrasi:</strong>
        </div>
        <br>
        <div class="text-center">
            <img style="height: 60%; width: 60%;" src="data:image/png;base64,{{ $qrcode_base64 }}" alt="qrcode">
            <strong>
                <h1>{{ $pemeriksaan->code }}</h1>
            </strong>
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

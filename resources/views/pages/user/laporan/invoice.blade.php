<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $pemeriksaan->code ?? 'N/A' }}</title>
    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/favicon.png') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            margin: 1mm 5mm 20mm 5mm;
        }

        .header-table {
            width: 100%;
            border-bottom: 1px solid #999;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .header-logo {
            width: 80px;
            vertical-align: top;
        }

        .header-text {
            font-size: 12px;
            line-height: 1.4;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
        }

        .header-sub {
            font-size: 11px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 60px;
            text-align: left;
            line-height: 35px;
        }

        .footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 12px;
            color: #555;
            }

        .header img {
            height: 70px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .table-outline {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-outline th,
        .table-outline td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .h-100 {
            height: 100px;
        }

        .col-3 {
            width: 33%;
        }

        .signature {
            width: 100%;
            margin-top: 30px;
        }

        .signature td {
            text-align: center;
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .no-border td {
            border: none !important;
        }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('media/favicons/favicon.png') }}" width="70">
            </td>
            <td class="header-text">
                <div class="header-title">Praktek Mandiri dr. Naya</div>
                <div class="header-sub">
                    SIP No. 446-0674-SIP TAHUN 2024<br>
                    Jalan Taman Cimanggu Tengah No.11<br>
                    Taman Cimanggu - Kota Bogor<br>
                    Telp. 0895 0894 7548 ; IG. @usgaja.official
                </div>
            </td>
        </tr>
    </table>
    <div class="footer">
        <i> USGaja © {{ \Carbon\Carbon::now()->translatedFormat('Y') }} - (Dokumen ini dicetak pada {{ \Carbon\Carbon::now() }})</i>
    </div>

    <div class="title">
        INVOICE PEMBAYARAN
    </div>

    <table class="table no-border">
        <tr>
            <td><b>No. Registrasi</b></td>
            <td>: {{ $pemeriksaan->code ?? '-' }}</td>
        </tr>
        <tr>
            <td><b>Pasien</b></td>
            <td>: {{ $pemeriksaan->pasien->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><b>NIK</b></td>
            <td>: {{ $pemeriksaan->pasien->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td><b>Tanggal Pemeriksaan</b></td>
            <td>: {{ $pemeriksaan->datetime_pemeriksaan_awal ?? '-' }}</td>
        </tr>
        <tr>
            <td><b>Tanggal Pembayaran</b></td>
            <td>: {{ $pemeriksaan->datetime_invoice ?? '-' }}</td>
        </tr>
    </table>

    <p><b>RINCIAN BIAYA:</b></p>
    <table class="table-outline">
        <thead>
            <tr>
                <th style="width: 40px;">NO.</th>
                <th>ITEMS</th>
                <th style="width: 100px;" class="text-right">SUB TOTAL (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp

            {{-- Layanan --}}
            @if ($pemeriksaan->layanans->count() > 0)
                @foreach ($pemeriksaan->layanans as $item)
                    @php $harga = $item->layanan->harga ?? 0; $total += $harga; @endphp
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td>{{ $item->layanan->name ?? '-' }} ({{ $item->layanan->kategori->name ?? '-' }})</td>
                        <td class="text-right">{{ number_format($harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif

            {{-- Obat --}}
            @if ($pemeriksaan->obats->where('is_confirmed', 1)->count() > 0)
                @foreach ($pemeriksaan->obats->where('is_confirmed', 1) as $item)
                    @php $harga = ($item->obat->harga_jual ?? 0) * ($item->jumlah ?? 1); $total += $harga; @endphp
                    <tr>
                        <td style="text-align: center">{{ $pemeriksaan->layanans->count() + $loop->iteration }}</td>
                        <td>{{ $item->obat->name ?? '-' }} ({{ $item->jumlah ?? 0 }} x Rp.
                            {{ number_format($item->obat->harga_jual ?? 0, 0, ',', '.') }})
                        </td>
                        <td class="text-right">{{ number_format($harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif

            {{-- Jika tidak ada layanan/obat --}}
            @if ($pemeriksaan->layanans->count() == 0 && $pemeriksaan->obats->count() == 0)
                <tr>
                    <td colspan="3" class="text-center">Tidak ada biaya tercatat</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right">TOTAL BAYAR</td>
                <td class="text-right">Rp. {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">TOTAL DISKON</td>
                <td class="text-right">Rp. {{ number_format($pemeriksaan->total_diskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="2" class="text-right">GRAND TOTAL</th>
                <th class="text-right"><b>Rp. {{ number_format($pemeriksaan->total_grand, 0, ',', '.') }}</b></th>
            </tr>
        </tfoot>
    </table>

    <p><b>PEMBAYARAN:</b></p>
    <table class="table no-border">
        <tr>
            <td style="width: 150px">Metode Pembayaran</td>
            <td>: {{ $pemeriksaan->metode_pembayaran->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status Pembayaran</td>
            <td>: {{ $pemeriksaan->status_pembayaran->name ?? '-' }}</td>
        </tr>
    </table>

        <table class="table signature">
            <tr>
                <td class="col-3"></td>
                <td class="col-3"></td>
                <td class="col-3">Petugas Kasir,</td>
            </tr>
            <tr>
                <td class="h-100"></td>
                <td class="h-100"></td>
                <td class="h-100"></td>
            </tr>
            <tr>
                <td class="h-15"></td>
                <td class="h-15"></td>
                <td class="h-15 font-weight-bold" style="border-bottom:1pt solid black;"></td>
            </tr>
        </table>

</body>
</html>

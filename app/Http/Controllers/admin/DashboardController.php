<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rawilk\Printing\Facades\Printing;
use Rawilk\Printing\Receipts\ReceiptPrinter;

class DashboardController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:dashboard.read')->only('index');

        // selain index
        $this->middleware('permission:dashboard.write')
            ->except('index');
    }

    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $end_date = $request->end_date
            ? Carbon::parse($request->end_date)->toDateString()
            : Carbon::today()->toDateString();

        $start_date = $request->start_date
            ? Carbon::parse($request->start_date)->toDateString()
            : Carbon::parse($end_date)->subDays(30)->toDateString();

        // QUERY DATA
        $pasien_baru = Pasien::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();

        $pasien_berulang = Pemeriksaan::select('pasien_id')
            ->whereDate('datetime', '>=', $start_date)
            ->whereDate('datetime', '<=', $end_date)
            ->where('status_pemeriksaan_id', 4) //Closed
            ->where('status_pembayaran_id', 2) //Lunas
            ->groupBy('pasien_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $jumlah_pemeriksaan = Pemeriksaan::whereDate('datetime', '>=', $start_date)
            ->whereDate('datetime', '<=', $end_date)
            ->where('status_pemeriksaan_id', 4) //Closed
            ->where('status_pembayaran_id', 2) //Lunas
            ->count();

        $pendapatan = Pemeriksaan::whereDate('datetime', '>=', $start_date)
            ->whereDate('datetime', '<=', $end_date)
            ->where('status_pemeriksaan_id', 4) //Closed
            ->where('status_pembayaran_id', 2) //Lunas
            ->sum('total_bayar');


        // FORMAT RIBUAN
        $pasien_baru = number_format($pasien_baru, 0, ',', '.');
        $pasien_berulang = number_format($pasien_berulang, 0, ',', '.');
        $jumlah_pemeriksaan = number_format($jumlah_pemeriksaan, 0, ',', '.');
        $pendapatan = "Rp. " . number_format($pendapatan, 0, ',', '.');


        // QUERY CHART
        $total_seconds = Pemeriksaan::whereDate('datetime', '>=', $start_date)
            ->whereDate('datetime', '<=', $end_date)
            ->where('status_pemeriksaan_id', 4) // Closed
            ->where('status_pembayaran_id', 2)  // Lunas
            ->get()
            ->sum(function($pemeriksaan) {
                // pastikan kolom datetime_invoice tidak null
                if ($pemeriksaan->datetime_invoice && $pemeriksaan->datetime) {
                    $start = Carbon::parse($pemeriksaan->datetime);
                    $end   = Carbon::parse($pemeriksaan->datetime_invoice);
                    return $end->diffInSeconds($start);
                }
                return 0;
            });

        // hitung rata-rata dalam menit
        $average_service_time = $jumlah_pemeriksaan > 0
            ? round($total_seconds / 60 / $jumlah_pemeriksaan, 2)
            : 0;

        // pastikan absolute
        $average_service_time = abs($average_service_time);


        $start = Carbon::parse($start_date);
        $end   = Carbon::parse($end_date);

        // Pasien per hari
        $pasienData = Pemeriksaan::select(DB::raw('DATE(datetime) as date'), DB::raw('COUNT(*) as total'))
            ->whereDate('datetime', '>=', $start)
            ->whereDate('datetime', '<=', $end)
            ->where('status_pemeriksaan_id', 4) // Closed
            ->where('status_pembayaran_id', 2) // Lunas
            ->groupBy(DB::raw('DATE(datetime)'))
            ->pluck('total','date');

        // Revenue per hari
        $revenueData = Pemeriksaan::select(DB::raw('DATE(datetime) as date'), DB::raw('SUM(total_bayar) as total'))
            ->whereDate('datetime', '>=', $start)
            ->whereDate('datetime', '<=', $end)
            ->where('status_pemeriksaan_id', 4) // Closed
            ->where('status_pembayaran_id', 2) // Lunas
            ->groupBy(DB::raw('DATE(datetime)'))
            ->pluck('total','date');

        // Siapkan array tanggal, pasien, dan revenue
        $dates = $pasienSeries = $revenueSeries = [];

        for ($date = $start; $date->lte($end); $date->addDay()) {
            $key = $date->format('Y-m-d');
            $dates[] = $date->format('d-m-Y');
            $pasienSeries[] = $pasienData[$key] ?? 0;
            $revenueSeries[] = isset($revenueData[$key]) ? round($revenueData[$key]/1_000_000, 2) : 0; // revenue dalam jt
        }


        // Ambil jam unik
        $hours = Pemeriksaan::whereDate('datetime', '>=', $start_date)
            ->whereDate('datetime', '<=', $end_date)
            ->where('status_pemeriksaan_id', 4)
            ->where('status_pembayaran_id', 2)
            ->select(DB::raw('HOUR(datetime) as hour'))
            ->distinct()
            ->orderBy('hour')
            ->pluck('hour')
            ->map(fn($h)=>str_pad($h,2,'0',STR_PAD_LEFT))
            ->toArray();

        // Ambil nama hari unik dari datetime
        $rawDays = Pemeriksaan::whereDate('datetime', '>=', $start_date)
            ->whereDate('datetime', '<=', $end_date)
            ->where('status_pemeriksaan_id', 4) // Closed
            ->where('status_pembayaran_id', 2) // Lunas
            ->select(DB::raw('DAYOFWEEK(datetime) as day')) // 1=Min, 2=Sen, ...,7=Sab
            ->distinct()
            ->orderBy('day')
            ->pluck('day')
            ->toArray();

        // Map nomor hari ke nama hari Indonesia
        $dayMap = [1=>'Minggu',2=>'Senin',3=>'Selasa',4=>'Rabu',5=>'Kamis',6=>'Jumat',7=>'Sabtu'];
        $days_heatmap = array_map(fn($d)=>$dayMap[$d], $rawDays);

        // Query jumlah pasien per hari & jam
        $rawData = Pemeriksaan::select(
                DB::raw('HOUR(datetime) as hour'),
                DB::raw('DAYOFWEEK(datetime) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->whereDate('datetime', '>=', $start_date)
            ->whereDate('datetime', '<=', $end_date)
            ->where('status_pemeriksaan_id', 4) // Closed
            ->where('status_pembayaran_id', 2) // Lunas
            ->groupBy(DB::raw('DAYOFWEEK(datetime)'), DB::raw('HOUR(datetime)'))
            ->get();

        // Map data ke index [x, y, value] sesuai Highcharts
        $heatmapData = [];
        foreach($rawData as $row){
            $xIndex = array_search(str_pad($row->hour,2,'0',STR_PAD_LEFT), $hours);
            $yIndex = array_search($dayMap[$row->day], $days_heatmap);
            if($xIndex !== false && $yIndex !== false){
                $heatmapData[] = [$xIndex, $yIndex, $row->total];
            }
        }


        return view('pages.admin.dashboard.index', compact([
            'start_date',
            'end_date',
            'pasien_baru',
            'pasien_berulang',
            'jumlah_pemeriksaan',
            'pendapatan',
            'average_service_time',
            'dates',
            'pasienSeries',
            'revenueSeries',
            'hours',
            'days_heatmap',
            'heatmapData',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\user;

use App\DataTables\HasilDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\SendMediaToWhatsapp;
use App\Models\Pemeriksaan;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class HasilController extends Controller
{
    public function index(HasilDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $start_date = $request->start_date ?? Carbon::now()->format('Y-m-d');
        $end_date = $request->end_date ?? $start_date;

        return $dataTable->with([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('pages.user.hasil.index', compact([
            'start_date',
            'end_date',
        ]));
    }

    public function create()
    {
        Artisan::call('pemeriksaan:scan-media');

        $output = Artisan::output();

        return redirect()->route('hasil.index')->withNotify($output);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        foreach ($pemeriksaan->medias as $item) {
            SendMediaToWhatsapp::dispatch($item->media_path, $pemeriksaan->pasien->no_hp, $item->media_type);
        }

        return redirect()->route('hasil.index')
            ->withNotify("File sedang dikirim ke WA. Harap periksa berkala.");
    }


    // public function edit(string $uuid, WhatsappService $whatsapp)
    // {
    //     $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

    //     // pastikan folder tmp ada
    //     $tmpDir = storage_path('app/tmp');
    //     if (!file_exists($tmpDir)) {
    //         mkdir($tmpDir, 0777, true);
    //     }

    //     foreach ($pemeriksaan->medias as $item) {

    //         $sftpPath = $item->media_path;
    //         $filename = basename($sftpPath);

    //         // download ke tmp
    //         $stream = Storage::disk('exam_sftp')->readStream($sftpPath);
    //         if (!$stream) {
    //             logger()->error('SFTP stream gagal', ['path' => $sftpPath]);
    //             continue;
    //         }

    //         $tmpPath = $tmpDir . '/' . $filename;
    //         $localStream = fopen($tmpPath, 'w');
    //         stream_copy_to_stream($stream, $localStream);

    //         fclose($stream);
    //         fclose($localStream);

    //         // upload ke WhatsApp
    //         $whatsapp->sendImage(
    //             $pemeriksaan->pasien->no_hp,
    //             fopen($tmpPath, 'r'),
    //             $filename,
    //             'Hasil Pemeriksaan'
    //         );

    //         // hapus file tmp
    //         unlink($tmpPath);
    //     }

    //     return redirect()->route('hasil.index')->withNotify("File Photo & Video berhasil dikirim ke No WA <b>{$pemeriksaan->pasien->no_hp}</b>.");
    // }


    // public function edit(string $uuid, WhatsappService $whatsapp)
    // {
    //     // test number
    //     $number = '6287723704469';

    //     // test file path di storage/app/tmp
    //     $tmpPath = storage_path('app/tmp/01000001.jpeg');

    //     if (!file_exists($tmpPath)) {
    //         return "File not found: {$tmpPath}";
    //     }

    //     // send image
    //     $result = $whatsapp->sendImage(
    //         $number,
    //         fopen($tmpPath, 'r'),
    //         '01000001.jpeg',
    //         'Test kirim WA'
    //     );

    //     return redirect()->route('hasil.index')
    //         ->withNotify("File berhasil dikirim ke No WA <b>{$number}</b>.");
    // }


    public function update(Request $request, string $uuid)
    {
        //
    }

    public function destroy(string $uuid)
    {
        //
    }
}

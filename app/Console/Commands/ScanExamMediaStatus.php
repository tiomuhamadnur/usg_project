<?php

namespace App\Console\Commands;

use App\Models\ExamMediaStatus;
use App\Models\Pemeriksaan;
use App\Services\ExamMedia\ExamMediaScannerService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScanExamMediaStatus extends Command
{
    protected $signature = 'pemeriksaan:scan-media';
    protected $description = 'Scan exam media via FTP and update status table';

    protected ExamMediaScannerService $scanner;

    public function __construct(ExamMediaScannerService $scanner)
    {
        parent::__construct();
        $this->scanner = $scanner;
    }

    public function handle()
    {
        // $today = Carbon::today();
        $today = Carbon::create(2026, 1, 17, 0, 0, 0);
        $dateFolder = $today->format('Ymd');

        $pemeriksaans = Pemeriksaan::whereBetween(
            'datetime_registrasi',
            [$today->copy()->startOfDay(), $today->copy()->endOfDay()]
        )->get();

        foreach ($pemeriksaans as $pemeriksaan) {

            $medias = $this->scanner->scan(
                $pemeriksaan->code,
                $dateFolder
            );

            foreach ($medias as $media) {
                ExamMediaStatus::updateOrCreate(
                    [
                        'pemeriksaan_id' => $pemeriksaan->id,
                        'media_path'     => $media['path'],
                    ],
                    [
                        'media_type'      => $media['type'],
                        'last_checked_at' => now(),
                    ]
                );
            }
        }

        $this->info('FTP exam media scan completed');
        return Command::SUCCESS;
    }
}

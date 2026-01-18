<?php

namespace App\Services\ExamMedia;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ExamMediaScannerService
{
    protected $disk;

    protected array $photoExt = ['jpeg'];
    protected array $videoExt = ['mp4'];

    public function __construct()
    {
        $this->disk = Storage::disk('exam_sftp');
    }

    /**
     * Scan media via FTP
     */
    public function scan(string $code, string $dateFolder): array
    {
        $result = [];

        // HARUS masuk ke folder EXAM_DAT dulu
        $dateFolder = "EXAM_DAT/{$dateFolder}";

        if (!$this->disk->exists($dateFolder)) {
            Log::warning('SFTP date folder not found', [
                'path' => $dateFolder
            ]);
            return [];
        }

        // list folder di tanggal tsb
        $examFolders = $this->disk->directories($dateFolder);

        foreach ($examFolders as $examFolder) {

            // filter berdasarkan code
            if (!str_contains($examFolder, $code)) {
                continue;
            }

            $files = $this->disk->files($examFolder);

            foreach ($files as $file) {
                $filename = basename($file);

                // skip file metadata macOS
                if (strpos($filename, '._') === 0) {
                    continue;
                }

                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (in_array($ext, $this->photoExt)) {
                    $type = 'photo';
                } elseif (in_array($ext, $this->videoExt)) {
                    $type = 'video';
                } else {
                    continue;
                }

                $result[] = [
                    'path' => $file, // SUDAH RELATIF
                    'type' => $type,
                ];
            }
        }

        return $result;
    }
}

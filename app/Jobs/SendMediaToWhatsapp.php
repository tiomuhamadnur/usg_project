<?php

namespace App\Jobs;

use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendMediaToWhatsapp implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $sftpPath;
    protected $number;
    protected $media_type;

    public function __construct($sftpPath, $number, $media_type)
    {
        $this->sftpPath = $sftpPath;
        $this->number = $number;
        $this->media_type = $media_type;
    }

    public function handle(WhatsappService $whatsapp)
    {
        $tmpDir = storage_path('app/tmp');
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        $filename = basename($this->sftpPath);
        $tmpPath = $tmpDir . '/' . $filename;

        // download ke tmp
        $stream = Storage::disk('exam_sftp')->readStream($this->sftpPath);
        if (!$stream) {
            logger()->error('SFTP stream gagal', ['path' => $this->sftpPath]);
            return;
        }

        $localStream = fopen($tmpPath, 'w');
        stream_copy_to_stream($stream, $localStream);
        fclose($stream);
        fclose($localStream);

        // upload ke WhatsApp
        $whatsapp->sendImage(
            $this->number,
            fopen($tmpPath, 'r'),
            $filename,
            '',
            $this->media_type,
        );

        // hapus file tmp
        unlink($tmpPath);
    }
}

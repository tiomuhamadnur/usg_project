<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Pemeriksaan extends Model
{
    use SoftDeletes;

    protected $table = 'pemeriksaan';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->code = self::generateUniqueCode();
            $model->status_pemeriksaan_id = 1; //awal buat langsung di-set open
            $model->status_pembayaran_id = 1; //awal buat langsung di-set belum bayar
            $model->admin_id = Auth::user()->id; //Yang membuat awal harusnya admin
        });
    }

    private static function generateUniqueCode()
    {
        do {
            $code = 'REG-' . Str::upper(Str::random(5));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public static function generateNoUrut($room_id, $datetime)
    {
        $room = Room::findOrFail($room_id);
        $roomCode = strtoupper($room->code);

        $date = Carbon::parse($datetime)->toDateString(); // format YYYY-MM-DD

        $lastEntry = Pemeriksaan::whereDate('datetime', $date)
                ->where('room_id', $room_id)
                ->orderBy('no_urut', 'desc')
                ->first();

        // Tentukan nomor urut berikutnya
        if ($lastEntry && preg_match('/(\d{3})$/', $lastEntry->no_urut, $match)) {
            $nextNumber = (int) $match[1] + 1;
        } else {
            $nextNumber = 1;
        }

        // Format nomor urut: A-001, B-005, dst
        $formattedNoUrut = $roomCode . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return $formattedNoUrut;
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function suster()
    {
        return $this->belongsTo(User::class, 'suster_id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function status_pemeriksaan()
    {
        return $this->belongsTo(StatusPemeriksaan::class);
    }

    public function status_pembayaran()
    {
        return $this->belongsTo(StatusPembayaran::class);
    }

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}

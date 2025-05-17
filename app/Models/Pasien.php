<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Pasien extends Model
{
    use SoftDeletes;

    protected $table = 'pasien';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->member_code = self::generateUniqueCode();
        });
    }

    private static function generateUniqueCode()
    {
        do {
            $code = 'MEM-' . Str::upper(Str::random(5));
        } while (self::where('member_code', $code)->exists());

        return $code;
    }

    public function getUmurAttribute()
    {
        $diff = Carbon::parse($this->tanggal_lahir)->diff(Carbon::now());
        return (object) [
            'tahun' => $diff->y,
            'bulan' => $diff->m,
            'hari' => $diff->d,
        ];
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function golongan_darah()
    {
        return $this->belongsTo(GolonganDarah::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function hubungan_pasien()
    {
        return $this->belongsTo(HubunganPasien::class);
    }

    public function pj_gender()
    {
        return $this->belongsTo(Gender::class, 'pj_gender_id');
    }

    public function pj_provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'pj_provinsi_id');
    }

    public function pj_kota()
    {
        return $this->belongsTo(Kota::class, 'pj_kota_id');
    }

    public function pj_kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'pj_kecamatan_id');
    }

    public function pj_kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'pj_kelurahan_id');
    }
}

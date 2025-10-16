<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LogObat extends Model
{
    use SoftDeletes;

    protected $table = 'log_obat';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->user_id = Auth::user()->id;
        });
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

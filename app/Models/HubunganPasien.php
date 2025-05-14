<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HubunganPasien extends Model
{
    use SoftDeletes;

    protected $table = 'hubungan_pasien';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
        $model->uuid = Str::uuid();
        });
    }
}

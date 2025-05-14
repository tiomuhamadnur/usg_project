<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GolonganDarah extends Model
{
    use SoftDeletes;

    protected $table = 'golongan_darah';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
        $model->uuid = Str::uuid();
        });
    }
}

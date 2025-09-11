<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Obat extends Model
{
    use SoftDeletes;

    protected $table = 'obat';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function sediaan()
    {
        return $this->belongsTo(Sediaan::class);
    }
}

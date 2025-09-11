<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use SoftDeletes;

    protected $table = 'layanan';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}

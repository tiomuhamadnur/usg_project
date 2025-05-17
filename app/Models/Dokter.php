<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Dokter extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('dokter', function (Builder $builder) {
            $builder->where('role_id', 3);
        });
    }
}

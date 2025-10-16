<?php

namespace App\Observers;

use App\Models\LogObat;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class LogObatObserver
{
    public function created(LogObat $logObat): void
    {
        DB::transaction(function () use ($logObat) {
            $obat = Obat::where('id', $logObat->obat_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($logObat->tipe === '-') {
                if ($obat->stock < $logObat->qty) {
                    throw new \Exception("Stock tidak mencukupi untuk obat {$obat->nama}");
                }
                $obat->stock -= $logObat->qty;
            } elseif ($logObat->tipe === '+') {
                $obat->stock += $logObat->qty;
            }

            $obat->save();
        });
    }

    public function updated(LogObat $logObat): void
    {
        //
    }

    public function deleted(LogObat $logObat): void
    {
        //
    }

    public function restored(LogObat $logObat): void
    {
        //
    }

    public function forceDeleted(LogObat $logObat): void
    {
        //
    }
}

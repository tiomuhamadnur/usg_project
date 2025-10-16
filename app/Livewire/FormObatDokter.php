<?php

namespace App\Livewire;

use App\Models\Obat;
use Livewire\Component;

class FormObatDokter extends Component
{
    public $obat_id = null;

    public function render()
    {
        $obats = Obat::orderBy('name', 'asc')->get();
        $obat = null;

        if($this->obat_id) {
            $obat = Obat::find($this->obat_id);
        }

        return view('livewire.form-obat-dokter', [
            'obats' => $obats,
            'obat' => $obat,
        ]);
    }
}

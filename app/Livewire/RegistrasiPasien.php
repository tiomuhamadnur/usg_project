<?php

namespace App\Livewire;

use App\Models\Pasien;
use Livewire\Component;

class RegistrasiPasien extends Component
{
    public $value = null;

    public function render()
    {
        $pasiens = collect();

        if($this->value) {
            $pasiens = Pasien::where('name', 'LIKE', "%{$this->value}%")
                ->orWhere('nik', 'LIKE', "%{$this->value}%")
                ->orWhere('no_hp', 'LIKE', "%{$this->value}%")
                ->orWhere('member_code', 'LIKE', "%{$this->value}%")
                ->get();
        }

        return view('livewire.registrasi-pasien', [
            'pasiens' => $pasiens
        ]);
    }
}

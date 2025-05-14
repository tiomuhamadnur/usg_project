<?php

namespace App\Livewire;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Provinsi;
use Livewire\Component;

class FormAddress extends Component
{
    public $provinsi_id = null;
    public $kota_id = null;
    public $kecamatan_id = null;
    public $kelurahan_id = null;
    public $prefix = '';

    public function mount($prefix = '')
    {
        $this->prefix = $prefix;
    }

    public function render()
    {
        $provinsi = Provinsi::orderBy('name', 'ASC')->get();
        $kota = collect();
        $kecamatan = collect();
        $kelurahan = collect();

        if ($this->provinsi_id) {
            $kota = Kota::query()
                ->when($this->provinsi_id, function($query) {
                    return $query->where('provinsi_id', $this->provinsi_id);
                })
                ->orderBy('name', 'ASC')
                ->get();
        }

        if ($this->kota_id) {
            $kecamatan = Kecamatan::query()
                ->when($this->kota_id, function($query) {
                    return $query->where('kota_id', $this->kota_id);
                })
                ->orderBy('name', 'ASC')
                ->get();
        }

        if ($this->kecamatan_id) {
            $kelurahan = Kelurahan::query()
                ->when($this->kecamatan_id, function($query) {
                    return $query->where('kecamatan_id', $this->kecamatan_id);
                })
                ->orderBy('name', 'ASC')
                ->get();
        }

        return view('livewire.form-address', compact('provinsi', 'kota', 'kecamatan', 'kelurahan'));
    }
}

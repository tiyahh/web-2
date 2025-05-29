<?php

namespace App\Livewire\UnitKerja;

use Livewire\Component;
use App\Models\UnitKerja;

class CreateUnitKerja extends Component
{
    public $nama_unit;

    public function save()
    {
        $this->validate([
            'nama_unit' => 'required'
        ]);

        UnitKerja::create([
            'nama_unit' => $this->nama_unit
        ]);

        session()->flash('message', 'Unit Kerja berhasil ditambahkan.');
        return redirect()->route('unitkerja.index');
    }

    public function render()
    {
        return view('livewire.unit-kerja.create-unit-kerja');
    }
}

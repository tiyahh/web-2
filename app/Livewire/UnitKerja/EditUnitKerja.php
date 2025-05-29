<?php

namespace App\Livewire\UnitKerja;

use Livewire\Component;
use App\Models\UnitKerja;

class EditUnitKerja extends Component
{
    public $unitkerjaId;
    public $nama_unit;

    public function mount($unitkerja)
    {
        $unit = UnitKerja::findOrFail($unitkerja);
        $this->unitkerjaId = $unit->id;
        $this->nama_unit = $unit->nama_unit;
    }

    public function update()
    {
        $this->validate(['nama_unit' => 'required']);

        $unit = UnitKerja::find($this->unitkerjaId);
        $unit->update(['nama_unit' => $this->nama_unit]);

        session()->flash('message', 'Unit Kerja berhasil diperbarui.');
        return redirect()->route('unitkerja.index');
    }

    public function render()
    {
        return view('livewire.unit-kerja.edit-unit-kerja');
    }
}

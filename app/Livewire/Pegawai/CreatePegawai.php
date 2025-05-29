<?php

namespace App\Livewire\Pegawai;

use Livewire\Component;
use App\Models\Pegawai;

class CreatePegawai extends Component
{
    public $nama, $nip, $jabatan;

    public function save()
    {
        $this->validate([
            'nama' => 'required',
            'nip' => 'required|unique:pegawais,nip',
            'jabatan' => 'required'
        ]);

        Pegawai::create([
            'nama' => $this->nama,
            'nip' => $this->nip,
            'jabatan' => $this->jabatan
        ]);

        session()->flash('message', 'Pegawai berhasil ditambahkan.');
        return redirect()->route('pegawai.index');
    }

    public function render()
    {
        return view('livewire.pegawai.create-pegawai');
    }
}

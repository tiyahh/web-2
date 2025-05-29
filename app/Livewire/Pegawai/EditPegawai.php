<?php

namespace App\Livewire\Pegawai;

use Livewire\Component;
use App\Models\Pegawai;

class EditPegawai extends Component
{
    public $pegawaiId, $nama, $nip, $jabatan;

    public function mount($pegawai)
    {
        $data = Pegawai::findOrFail($pegawai);
        $this->pegawaiId = $data->id;
        $this->nama = $data->nama;
        $this->nip = $data->nip;
        $this->jabatan = $data->jabatan;
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'nip' => 'required',
            'jabatan' => 'required',
        ]);

        $pegawai = Pegawai::find($this->pegawaiId);

        if ($pegawai) {
            $pegawai->update([
                'nama' => $this->nama,
                'nip' => $this->nip,
                'jabatan' => $this->jabatan,
            ]);

            session()->flash('message', 'Pegawai berhasil diperbarui.');
            return redirect()->route('pegawai.index');
        } else {
            session()->flash('error', 'Pegawai tidak ditemukan.');
        }
    }

    public function render()
    {
        return view('livewire.edit-pegawai');
    }
}

<?php
namespace App\Livewire\Peminjaman;

use Livewire\Component;
use App\Models\Peminjaman;

class EditPeminjaman extends Component
{
    public $peminjamanId, $nama, $tanggal;

    public function mount(Peminjaman $peminjaman)
    {
        $this->peminjamanId = $peminjaman->id;
        $this->nama = $peminjaman->nama;
        $this->tanggal = $peminjaman->tanggal;
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
        ]);

        $peminjaman = Peminjaman::findOrFail($this->peminjamanId);
        $peminjaman->update([
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
        ]);

        session()->flash('success', 'Data berhasil diupupdate.');
        return redirect()->route('peminjaman.index');
    }

    public function render()
    {
        return view('livewire.peminjaman.edit-peminjaman');
    }
}

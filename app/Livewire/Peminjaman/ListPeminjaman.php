<?php
namespace App\Livewire\Peminjaman;

use Livewire\Component;
use App\Models\Peminjaman;

class ListPeminjaman extends Component
{
    public function delete($id)
    {
        $p = Peminjaman::find($id);
        if ($p) {
            $p->delete();
            session()->flash('message', 'Peminjaman berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.peminjaman.list-peminjaman', [
            'peminjaman' => Peminjaman::with('pegawai')->get()
        ]);
    }
}

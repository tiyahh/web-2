<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;


class PeminjamanController extends Controller
{
   public function edit($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    return view('peminjaman.edit', compact('peminjaman'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'tanggal' => 'required|date',
    ]);

    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->update($request->all());

    return redirect()->route('peminjaman.index');
}

}

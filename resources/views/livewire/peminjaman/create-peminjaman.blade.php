<h2 class="text-xl font-bold">Tambah Peminjaman</h2>
<form method="POST" action="{{ route('peminjaman.store') }}">
    @csrf
    <input type="text" name="nama" placeholder="Nama" class="border p-2 mb-2 w-full" required>
    <input type="date" name="tanggal" class="border p-2 mb-2 w-full" required>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</button>
</form>

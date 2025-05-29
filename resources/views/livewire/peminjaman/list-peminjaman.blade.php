<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📋 List Peminjaman</h2>
        <a href="{{ route('peminjaman.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            ➕ Tambah
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Pegawai</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Barang</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tgl Pinjam</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tgl Kembali</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($peminjaman as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-800">{{ $p->pegawai->nama }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $p->barang }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $p->tanggal_pinjam }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $p->tanggal_kembali }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('peminjaman.edit', $p->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                ✏️ Edit
                            </a>
                            <button wire:click.prevent="delete('{{ $p->id }}')" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">✏️ Edit Peminjaman</h2>

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Pegawai</label>
            <input id="nama" type="text" wire:model="nama" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>
        </div>

        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
            <input id="tanggal" type="date" wire:model="tanggal" class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>

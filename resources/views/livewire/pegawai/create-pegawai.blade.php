<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-3">Tambah Unit Kerja</h2>
    <form wire:submit.prevent="save">
        <input type="text" wire:model="nama_unit" placeholder="Nama Unit" class="form-input mb-2 w-full">
        @error('nama_unit') <span class="text-red-500">{{ $message }}</span> @enderror
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

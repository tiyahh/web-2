<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-3">Edit Unit Kerja</h2>
    <form wire:submit.prevent="update">
        <input type="text" wire:model="nama_unit" class="form-input mb-2 w-full">
        @error('nama_unit') <span class="text-red-500">{{ $message }}</span> @enderror
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</div>

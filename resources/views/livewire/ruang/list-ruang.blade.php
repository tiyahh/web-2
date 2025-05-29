<div>
    <a href="{{ route('ruang.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">New Ruang</a>

    @if (session('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 mt-4">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full border mt-4">
        <thead>
            <tr>
                <th class="border p-2">Nama Ruang</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ruangs as $ruang)
                <tr>
                    <td class="border p-2">{{ $ruang->nama }}</td>
                    <td class="border p-2">
                        <a href="{{ route('ruang.edit', $ruang->id) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded mr-2">Edit</a>
                        <button wire:click="delete({{ $ruang->id }})"
                            class="bg-red-500 text-white px-3 py-1 rounded"
                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

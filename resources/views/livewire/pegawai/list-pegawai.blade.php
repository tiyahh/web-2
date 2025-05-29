<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-3">List Pegawai</h2>
    <div class="flex justify-between mb-3">
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary">New Pegawai</a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="w-full table-auto border-collapse border border-gray-400">
        <thead>
            <tr>
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">NIP</th>
                <th class="border px-4 py-2">Jabatan</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawais as $index => $pegawai)
            <tr>
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $pegawai->nama }}</td>
                <td class="border px-4 py-2">{{ $pegawai->nip }}</td>
                <td class="border px-4 py-2">{{ $pegawai->jabatan }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button wire:click="delete({{ $pegawai->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

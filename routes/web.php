<?php
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;

use Illuminate\Support\Facades\Route;
use App\Livewire\Ruang\CreateRuang;
use App\Livewire\Ruang\EditRuang;
use App\Livewire\Ruang\ListRuang;
use App\Livewire\Counter;

use App\Livewire\UnitKerja\CreateUnitKerja;
use App\Livewire\UnitKerja\EditUnitKerja;
use App\Livewire\UnitKerja\ListUnitKerja;

use App\Livewire\Pegawai\CreatePegawai;
use App\Livewire\Pegawai\EditPegawai;
use App\Livewire\Pegawai\ListPegawai;

use App\Livewire\Peminjaman\CreatePeminjaman;
use App\Livewire\Peminjaman\EditPeminjaman;
use App\Livewire\Peminjaman\ListPeminjaman;
use App\Http\Controllers\PeminjamanController;




Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('/counter', Counter::class);
// Membuat route untuk halaman list ruang
Route::get('ruang', ListRuang::class)->name('ruang.index');

// Membuat route untuk halaman create ruang
// Route::get('ruang/create', CreateRuang::class)->name('ruang.create');
 Route::get('/ruang/create', CreateRuang::class)->name('ruang.create');

/**
 * Route untuk halaman edit ruang
 * dengan parameter ruang di endpoint nya
 */
// Route::get('ruang/edit/{ruang}', EditRuang::class)->name('ruang.edit');
Route::get('/ruang/edit/{ruang}', EditRuang::class)->name('ruang.edit');

Route::get('/unitkerja/create', CreateUnitKerja::class)->name('unitkerja.create');
Route::get('/unitkerja/edit/{unitkerja}', EditUnitKerja::class)->name('unitkerja.edit');
Route::get('/unitkerja', ListUnitKerja::class)->name('unitkerja.index');

Route::get('/pegawai', ListPegawai::class)->name('pegawai.index');
Route::get('/pegawai/create', CreatePegawai::class)->name('pegawai.create');
Route::get('/pegawai/edit/{pegawai}', EditPegawai::class)->name('pegawai.edit');

Route::get('/peminjaman', ListPeminjaman::class)->name('peminjaman.index');
Route::get('/peminjaman/create', CreatePeminjaman::class)->name('peminjaman.create');
Route::get('/peminjaman/edit/{peminjaman}', EditPeminjaman::class)->name('peminjaman.edit');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');




require __DIR__.'/auth.php';

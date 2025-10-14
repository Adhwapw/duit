<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DompetController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $userId = Auth::id();

        $saldoAwal = \App\Models\Dompet::where('user_id',$userId)->sum('saldo_awal');

        $bulanIni = now()->startOfMonth();
        $pemasukanBulan = \App\Models\Transaksi::where('user_id',$userId)
            ->where('jenis','pemasukan')
            ->whereDate('tanggal','>=',$bulanIni)
            ->sum('jumlah');

        $pengeluaranBulan = \App\Models\Transaksi::where('user_id',$userId)
            ->where('jenis','pengeluaran')
            ->whereDate('tanggal','>=',$bulanIni)
            ->sum('jumlah');

        $dataKategori = \App\Models\Transaksi::where('user_id',$userId)
            ->whereDate('tanggal','>=',$bulanIni)
            ->selectRaw('kategori_id, SUM(jumlah) as total')
            ->groupBy('kategori_id')
            ->with('kategori:id,nama_kategori')
            ->get()
            ->map(fn($t)=>['nama'=>$t->kategori?->nama_kategori ?? 'Tanpa Kategori', 'total'=>(float)$t->total]);

        $totalSaldo = $saldoAwal
            + \App\Models\Transaksi::where('user_id',$userId)->where('jenis','pemasukan')->sum('jumlah')
            - \App\Models\Transaksi::where('user_id',$userId)->where('jenis','pengeluaran')->sum('jumlah');

        return view('dashboard.index', compact('totalSaldo','pemasukanBulan','pengeluaranBulan','dataKategori'));
    })->name('dashboard');

    Route::resource('dompet', DompetController::class)->except(['show']);
    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('transaksi', TransaksiController::class)->except(['show']);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/unduh', [LaporanController::class, 'unduh'])->name('laporan.unduh');
});

require __DIR__.'/auth.php';

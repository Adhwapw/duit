<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DompetController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TransferController;


Route::get('/', function () {
    if (Auth::check()) return redirect('/dashboard');
    return view('welcome'); // landing public dg tombol Daftar/Masuk
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $userId = Auth::id();

        // --- angka utama (sudah ada) ---
        $saldoAwal = \App\Models\Dompet::where('user_id', $userId)->sum('saldo_awal');
        $bulanIni = now()->startOfMonth();
        $dompetList   = \App\Models\Dompet::where('user_id', $userId)->get(['id', 'nama_dompet']);
        $kategoriList = \App\Models\Kategori::where('user_id', $userId)->get(['id', 'nama_kategori', 'tipe']);

        $pemasukanBulan = \App\Models\Transaksi::where('user_id', $userId)
            ->where('jenis', 'pemasukan')
            ->whereDate('tanggal', '>=', $bulanIni)
            ->sum('jumlah');

        $pengeluaranBulan = \App\Models\Transaksi::where('user_id', $userId)
            ->where('jenis', 'pengeluaran')
            ->whereDate('tanggal', '>=', $bulanIni)
            ->sum('jumlah');

        $dataKategori = \App\Models\Transaksi::where('user_id', $userId)
            ->whereDate('tanggal', '>=', $bulanIni)
            ->selectRaw('kategori_id, SUM(jumlah) as total')
            ->groupBy('kategori_id')
            ->with('kategori:id,nama_kategori')
            ->get()
            ->map(fn($t) => ['nama' => $t->kategori?->nama_kategori ?? 'Tanpa Kategori', 'total' => (float)$t->total]);

        $totalSaldo = $saldoAwal
            + \App\Models\Transaksi::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('jumlah')
            - \App\Models\Transaksi::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('jumlah');

        // --- RINGKAS PER DOMPET (baru) ---
        $dompetRingkas = \App\Models\Dompet::where('user_id', $userId)
            ->withSum(['transaksi as total_pemasukan' => function ($q) {
                $q->where('jenis', 'pemasukan');
            }], 'jumlah')
            ->withSum(['transaksi as total_pengeluaran' => function ($q) {
                $q->where('jenis', 'pengeluaran');
            }], 'jumlah')
            ->get()
            ->map(function ($d) {
                $pemasukan   = (float)($d->total_pemasukan ?? 0);
                $pengeluaran = (float)($d->total_pengeluaran ?? 0);
                return [
                    'id'         => $d->id,
                    'nama'       => $d->nama_dompet,
                    'jenis'      => $d->jenis_dompet,
                    'sisa_saldo' => (float)$d->saldo_awal + $pemasukan - $pengeluaran,
                ];
            });

        return view('dashboard.index', compact(
            'totalSaldo',
            'pemasukanBulan',
            'pengeluaranBulan',
            'dataKategori',
            'dompetRingkas',
            'dompetList',
            'kategoriList'
        ));
    })->name('dashboard');


    Route::resource('dompet', DompetController::class)->except(['show']);
    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('transaksi', TransaksiController::class)->except(['show']);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/unduh', [LaporanController::class, 'unduh'])->name('laporan.unduh');

    Route::get('/transfer', [TransferController::class, 'create'])->name('transfer.create');
    Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');
});


require __DIR__ . '/auth.php';

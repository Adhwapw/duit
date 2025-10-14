<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Dompet;
use App\Models\Kategori;
use App\Models\Transaksi;

class TransferController extends Controller
{
    /**
     * Tampilkan form transfer antar dompet.
     */
    public function create(Request $request)
    {
        $userId = Auth::id();

        // Ambil semua dompet milik user sebagai pilihan
        $dompet = Dompet::where('user_id', $userId)->get(['id','nama_dompet','jenis_dompet']);

        return view('transfer.create', compact('dompet'));
    }

    /**
     * Simpan transfer:
     * - Buat 1 transaksi pengeluaran di dompet sumber (kategori: Transfer Keluar)
     * - Buat 1 transaksi pemasukan di dompet tujuan (kategori: Transfer Masuk)
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        // Validasi input dasar
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jumlah'  => 'required|numeric|min:0.01',
            'sumber_dompet_id' => [
                'required',
                Rule::exists('dompet','id')->where(fn($q)=>$q->where('user_id',$userId)),
            ],
            'tujuan_dompet_id' => [
                'required',
                Rule::exists('dompet','id')->where(fn($q)=>$q->where('user_id',$userId)),
            ],
            'catatan' => 'nullable|string|max:255',
        ], [
            'tujuan_dompet_id.required' => 'Dompet tujuan wajib diisi.',
        ]);

        // Cegah transfer ke dompet yang sama
        if ($data['sumber_dompet_id'] == $data['tujuan_dompet_id']) {
            return back()
                ->withInput()
                ->with('ok', null)
                ->withErrors(['tujuan_dompet_id' => 'Dompet tujuan harus berbeda dengan dompet sumber.']);
        }

        // Pastikan kategori "Transfer Masuk" & "Transfer Keluar" ada untuk user ini
        $katMasuk = Kategori::firstOrCreate(
            ['user_id'=>$userId, 'nama_kategori'=>'Transfer Masuk', 'tipe'=>'pemasukan'],
            ['warna_opsional'=>null]
        );

        $katKeluar = Kategori::firstOrCreate(
            ['user_id'=>$userId, 'nama_kategori'=>'Transfer Keluar', 'tipe'=>'pengeluaran'],
            ['warna_opsional'=>null]
        );

        // CATAT TRANSAKSI GANDA (satu keluar, satu masuk)
        // 1) Pengeluaran di dompet sumber
        Transaksi::create([
            'user_id'     => $userId,
            'dompet_id'   => $data['sumber_dompet_id'],
            'kategori_id' => $katKeluar->id,
            'tanggal'     => $data['tanggal'],
            'jenis'       => 'pengeluaran',
            'jumlah'      => $data['jumlah'],
            'catatan'     => $data['catatan'] ? ('Transfer ke dompet ID '.$data['tujuan_dompet_id'].' - '.$data['catatan']) : ('Transfer ke dompet ID '.$data['tujuan_dompet_id']),
        ]);

        // 2) Pemasukan di dompet tujuan
        Transaksi::create([
            'user_id'     => $userId,
            'dompet_id'   => $data['tujuan_dompet_id'],
            'kategori_id' => $katMasuk->id,
            'tanggal'     => $data['tanggal'],
            'jenis'       => 'pemasukan',
            'jumlah'      => $data['jumlah'],
            'catatan'     => $data['catatan'] ? ('Transfer dari dompet ID '.$data['sumber_dompet_id'].' - '.$data['catatan']) : ('Transfer dari dompet ID '.$data['sumber_dompet_id']),
        ]);

        // Kembali ke dashboard agar langsung terlihat perubahan saldo
        return redirect()->route('dashboard')->with('ok','Transfer berhasil dicatat.');
    }
}

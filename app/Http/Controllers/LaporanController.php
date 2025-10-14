<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request) {
        $userId = Auth::id();
        $awal = $request->input('awal');
        $akhir = $request->input('akhir');

        $query = Transaksi::where('user_id',$userId)->with(['dompet','kategori'])->orderBy('tanggal','desc');

        if ($awal)  $query->whereDate('tanggal','>=',$awal);
        if ($akhir) $query->whereDate('tanggal','<=',$akhir);

        $items = $query->get();

        $pemasukan = $items->where('jenis','pemasukan')->sum('jumlah');
        $pengeluaran = $items->where('jenis','pengeluaran')->sum('jumlah');
        $saldoBersih = $pemasukan - $pengeluaran;

        return view('laporan.index', compact('items','awal','akhir','pemasukan','pengeluaran','saldoBersih'));
    }

    public function unduh(Request $request) : StreamedResponse {
        $userId = Auth::id();
        $awal = $request->input('awal');
        $akhir = $request->input('akhir');

        $query = Transaksi::where('user_id',$userId)->with(['dompet','kategori'])->orderBy('tanggal','desc');
        if ($awal)  $query->whereDate('tanggal','>=',$awal);
        if ($akhir) $query->whereDate('tanggal','<=',$akhir);

        $rows = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan.csv"',
        ];

        return response()->stream(function() use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['tanggal','jenis','dompet','kategori','jumlah','catatan']);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->tanggal,
                    $r->jenis,
                    $r->dompet?->nama_dompet,
                    $r->kategori?->nama_kategori,
                    number_format($r->jumlah,2,'.',''),
                    $r->catatan,
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Dompet;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Ambil parameter filter sederhana
        $q      = trim((string)$request->input('q'));          // kata kunci
        $jenis  = $request->input('jenis');                    // pemasukan/pengeluaran/null
        $awal   = $request->input('awal');                     // yyyy-mm-dd
        $akhir  = $request->input('akhir');

        $items = Transaksi::where('user_id', $userId)
            ->with(['dompet:id,nama_dompet', 'kategori:id,nama_kategori,tipe'])
            ->when($jenis, fn($qr) => $qr->where('jenis', $jenis))
            ->when($awal,  fn($qr) => $qr->whereDate('tanggal', '>=', $awal))
            ->when($akhir, fn($qr) => $qr->whereDate('tanggal', '<=', $akhir))
            // cari di catatan + nama dompet + nama kategori
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($sub) use ($q) {
                    $sub->where('catatan', 'like', "%{$q}%")
                        ->orWhereHas('dompet',   fn($d) => $d->where('nama_dompet',   'like', "%{$q}%"))
                        ->orWhereHas('kategori', fn($k) => $k->where('nama_kategori', 'like', "%{$q}%"));
                });
            })
            ->latest('tanggal')
            ->paginate(10)
            ->appends($request->only('q', 'jenis', 'awal', 'akhir'));

        // pilihan select di form
        $dompet  = \App\Models\Dompet::where('user_id', $userId)->get(['id', 'nama_dompet']);
        $kategori = \App\Models\Kategori::where('user_id', $userId)->get(['id', 'nama_kategori', 'tipe']);

        return view('transaksi.index', compact('items', 'q', 'jenis', 'awal', 'akhir', 'dompet', 'kategori'));
    }

    public function create()
    {
        $dompet = Dompet::where('user_id', Auth::id())->get();
        $kategori = Kategori::where('user_id', Auth::id())->get();
        return view('transaksi.create', compact('dompet', 'kategori'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jenis'   => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
            'jumlah'  => 'required|numeric|min:0.01',
            'dompet_id' => [
                'required',
                Rule::exists('dompet', 'id')->where(fn($q) => $q->where('user_id', $userId)),
            ],
            'kategori_id' => [
                'required',
                Rule::exists('kategori', 'id')->where(fn($q) => $q->where('user_id', $userId)),
            ],
            'catatan' => 'nullable|string|max:255',
        ]);

        $data['user_id'] = $userId;
        Transaksi::create($data);
        return $request->input('redirect_to') === 'dashboard'
            ? redirect()->route('dashboard')->with('ok', 'Transaksi dicatat.')
            : redirect()->route('transaksi.index')->with('ok', 'Transaksi dicatat.');
    }

    public function edit(Transaksi $transaksi)
    {
        abort_if($transaksi->user_id !== Auth::id(), 403);
        $dompet = Dompet::where('user_id', Auth::id())->get();
        $kategori = Kategori::where('user_id', Auth::id())->get();
        return view('transaksi.edit', compact('transaksi', 'dompet', 'kategori'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        abort_if($transaksi->user_id !== Auth::id(), 403);
        $userId = Auth::id();
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jenis'   => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
            'jumlah'  => 'required|numeric|min:0.01',
            'dompet_id' => [
                'required',
                Rule::exists('dompet', 'id')->where(fn($q) => $q->where('user_id', $userId)),
            ],
            'kategori_id' => [
                'required',
                Rule::exists('kategori', 'id')->where(fn($q) => $q->where('user_id', $userId)),
            ],
            'catatan' => 'nullable|string|max:255',
        ]);
        $transaksi->update($data);
        return redirect()->route('transaksi.index')->with('ok', 'Transaksi diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        abort_if($transaksi->user_id !== Auth::id(), 403);
        $transaksi->delete();
        return back()->with('ok', 'Transaksi dihapus.');
    }
}

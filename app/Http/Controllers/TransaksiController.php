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
    public function index() {
        $items = Transaksi::where('user_id', Auth::id())
            ->with(['dompet:id,nama_dompet','kategori:id,nama_kategori,tipe'])
            ->latest('tanggal')
            ->paginate(10);
        return view('transaksi.index', compact('items'));
    }

    public function create() {
        $dompet = Dompet::where('user_id', Auth::id())->get();
        $kategori = Kategori::where('user_id', Auth::id())->get();
        return view('transaksi.create', compact('dompet','kategori'));
    }

    public function store(Request $request) {
        $userId = Auth::id();
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jenis'   => ['required', Rule::in(['pemasukan','pengeluaran'])],
            'jumlah'  => 'required|numeric|min:0.01',
            'dompet_id' => [
                'required',
                Rule::exists('dompet','id')->where(fn($q)=>$q->where('user_id',$userId)),
            ],
            'kategori_id' => [
                'required',
                Rule::exists('kategori','id')->where(fn($q)=>$q->where('user_id',$userId)),
            ],
            'catatan' => 'nullable|string|max:255',
        ]);

        $data['user_id'] = $userId;
        Transaksi::create($data);
        return redirect()->route('transaksi.index')->with('ok','Transaksi dicatat.');
    }

    public function edit(Transaksi $transaksi) {
        abort_if($transaksi->user_id !== Auth::id(), 403);
        $dompet = Dompet::where('user_id', Auth::id())->get();
        $kategori = Kategori::where('user_id', Auth::id())->get();
        return view('transaksi.edit', compact('transaksi','dompet','kategori'));
    }

    public function update(Request $request, Transaksi $transaksi) {
        abort_if($transaksi->user_id !== Auth::id(), 403);
        $userId = Auth::id();
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jenis'   => ['required', Rule::in(['pemasukan','pengeluaran'])],
            'jumlah'  => 'required|numeric|min:0.01',
            'dompet_id' => [
                'required',
                Rule::exists('dompet','id')->where(fn($q)=>$q->where('user_id',$userId)),
            ],
            'kategori_id' => [
                'required',
                Rule::exists('kategori','id')->where(fn($q)=>$q->where('user_id',$userId)),
            ],
            'catatan' => 'nullable|string|max:255',
        ]);
        $transaksi->update($data);
        return redirect()->route('transaksi.index')->with('ok','Transaksi diperbarui.');
    }

    public function destroy(Transaksi $transaksi) {
        abort_if($transaksi->user_id !== Auth::id(), 403);
        $transaksi->delete();
        return back()->with('ok','Transaksi dihapus.');
    }
}

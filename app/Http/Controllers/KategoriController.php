<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index() {
        $items = Kategori::where('user_id', Auth::id())->latest('dibuat_pada')->paginate(10);
        return view('kategori.index', compact('items'));
    }

    public function create() { return view('kategori.create'); }

    public function store(Request $request) {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'warna_opsional' => 'nullable|string|max:20',
        ]);
        $data['user_id'] = Auth::id();
        Kategori::create($data);
        return redirect()->route('kategori.index')->with('ok','Kategori dibuat.');
    }

    public function edit(Kategori $kategori) {
        abort_if($kategori->user_id !== Auth::id(), 403);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori) {
        abort_if($kategori->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'warna_opsional' => 'nullable|string|max:20',
        ]);
        $kategori->update($data);
        return redirect()->route('kategori.index')->with('ok','Kategori diperbarui.');
    }

    public function destroy(Kategori $kategori) {
        abort_if($kategori->user_id !== Auth::id(), 403);
        $kategori->delete();
        return back()->with('ok','Kategori dihapus.');
    }
}

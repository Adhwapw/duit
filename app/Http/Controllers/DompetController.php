<?php
namespace App\Http\Controllers;

use App\Models\Dompet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DompetController extends Controller
{
    // Tampilkan daftar dompet milik user
    public function index() {
        $items = Dompet::where('user_id', Auth::id())->latest('dibuat_pada')->paginate(10);
        return view('dompet.index', compact('items'));
    }

    // Form tambah
    public function create() { return view('dompet.create'); }

    // Simpan dompet baru
    public function store(Request $request) {
        $data = $request->validate([
            'nama_dompet' => 'required|string|max:100',
            'jenis_dompet' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal'  => 'required|numeric|min:0',
            'keterangan'  => 'nullable|string|max:255',
        ]);
        $data['user_id'] = Auth::id();
        Dompet::create($data);
        return redirect()->route('dompet.index')->with('ok','Dompet dibuat.');
    }

    // Form edit
    public function edit(Dompet $dompet) {
        abort_if($dompet->user_id !== Auth::id(), 403);
        return view('dompet.edit', compact('dompet'));
    }

    // Update dompet
    public function update(Request $request, Dompet $dompet) {
        abort_if($dompet->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'nama_dompet' => 'required|string|max:100',
            'jenis_dompet' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal'  => 'required|numeric|min:0',
            'keterangan'  => 'nullable|string|max:255',
        ]);
        $dompet->update($data);
        return redirect()->route('dompet.index')->with('ok','Dompet diperbarui.');
    }

    // Hapus dompet
    public function destroy(Dompet $dompet) {
        abort_if($dompet->user_id !== Auth::id(), 403);
        $dompet->delete();
        return back()->with('ok','Dompet dihapus.');
    }
}



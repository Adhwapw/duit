@csrf
<div class="grid gap-4">
  <div>
    <label class="block text-sm mb-1">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', ($transaksi->tanggal ?? '') ) }}" class="w-full border rounded px-3 py-2">
    @error('tanggal')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Jenis</label>
    <select name="jenis" class="w-full border rounded px-3 py-2">
      @foreach(['pemasukan','pengeluaran'] as $opt)
        <option value="{{ $opt }}" @selected(old('jenis', $transaksi->jenis ?? '') === $opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('jenis')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Jumlah</label>
    <input type="number" step="0.01" min="0.01" name="jumlah" value="{{ old('jumlah', $transaksi->jumlah ?? '') }}" class="w-full border rounded px-3 py-2">
    @error('jumlah')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Dompet</label>
    <select name="dompet_id" class="w-full border rounded px-3 py-2">
      @foreach($dompet as $d)
        <option value="{{ $d->id }}" @selected(old('dompet_id', $transaksi->dompet_id ?? '') == $d->id)>{{ $d->nama_dompet }}</option>
      @endforeach
    </select>
    @error('dompet_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Kategori</label>
    <select name="kategori_id" class="w-full border rounded px-3 py-2">
      @foreach($kategori as $k)
        <option value="{{ $k->id }}" @selected(old('kategori_id', $transaksi->kategori_id ?? '') == $k->id)>{{ $k->nama_kategori }} ({{ $k->tipe }})</option>
      @endforeach
    </select>
    @error('kategori_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Catatan (opsional)</label>
    <input name="catatan" value="{{ old('catatan', $transaksi->catatan ?? '') }}" class="w-full border rounded px-3 py-2">
  </div>
  <div class="flex gap-2">
    <button class="px-4 py-2 border rounded">Simpan</button>
    <a class="px-4 py-2 border rounded" href="{{ route('transaksi.index') }}">Batal</a>
  </div>
</div>

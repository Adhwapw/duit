@csrf
<div class="grid gap-4">
  <div>
    <label class="block text-sm mb-1">Nama Kategori</label>
    <input name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" class="w-full border rounded px-3 py-2">
    @error('nama_kategori')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Tipe</label>
    <select name="tipe" class="w-full border rounded px-3 py-2">
      @foreach(['pemasukan','pengeluaran'] as $opt)
        <option value="{{ $opt }}" @selected(old('tipe', $kategori->tipe ?? '') === $opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('tipe')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Warna (opsional)</label>
    <input name="warna_opsional" value="{{ old('warna_opsional', $kategori->warna_opsional ?? '') }}" class="w-full border rounded px-3 py-2">
  </div>
  <div class="flex gap-2">
    <button class="px-4 py-2 border rounded">Simpan</button>
    <a class="px-4 py-2 border rounded" href="{{ route('kategori.index') }}">Batal</a>
  </div>
</div>

@csrf
<div class="grid gap-4 card">
  <div>
    <label class="block text-sm mb-1 text-slate-700">Nama Kategori</label>
    <input name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" class="input">
    @error('nama_kategori')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">Tipe</label>
    <select name="tipe" class="select">
      @foreach(['pemasukan','pengeluaran'] as $opt)
        <option value="{{ $opt }}" @selected(old('tipe', $kategori->tipe ?? '') === $opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('tipe')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">
      Warna (opsional) <span class="text-xs text-slate-400">mis. #16a34a atau red</span>
    </label>
    <input name="warna_opsional" value="{{ old('warna_opsional', $kategori->warna_opsional ?? '') }}" class="input">
  </div>
  <div class="flex gap-2">
    <button class="btn-primary">Simpan</button>
    <a class="btn-ghost" href="{{ route('kategori.index') }}">Batal</a>
  </div>
</div>

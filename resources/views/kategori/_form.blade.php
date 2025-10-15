@csrf
<div class="grid gap-4 card-soft-blue">
  <div>
    <label class="block text-sm mb-1">Nama Kategori</label>
    <input name="nama_kategori" class="input" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}">
    @error('nama_kategori')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Tipe</label>
    <select name="tipe" class="select">
      @foreach(['pemasukan','pengeluaran'] as $opt)
        <option value="{{ $opt }}" @selected(old('tipe', $kategori->tipe ?? '')===$opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('tipe')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Warna (opsional)</label>
    <input name="warna_opsional" class="input" placeholder="#16a34a atau green"
           value="{{ old('warna_opsional', $kategori->warna_opsional ?? '') }}">
  </div>
  <div class="flex gap-2 justify-end">
    <button class="btn-primary">Simpan</button>
    <a href="{{ route('kategori.index') }}" class="btn-ghost">Batal</a>
  </div>
</div>

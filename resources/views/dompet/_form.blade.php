@csrf
<div class="grid gap-4">
  <div>
    <label class="block text-sm mb-1">Nama Dompet</label>
    <input name="nama_dompet" value="{{ old('nama_dompet', $dompet->nama_dompet ?? '') }}" class="w-full border rounded px-3 py-2">
    @error('nama_dompet')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Jenis Dompet</label>
    <select name="jenis_dompet" class="w-full border rounded px-3 py-2">
      @foreach(['tunai','bank','e-wallet'] as $opt)
        <option value="{{ $opt }}" @selected(old('jenis_dompet', $dompet->jenis_dompet ?? '') === $opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('jenis_dompet')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Saldo Awal</label>
    <input type="number" step="0.01" min="0" name="saldo_awal" value="{{ old('saldo_awal', $dompet->saldo_awal ?? 0) }}" class="w-full border rounded px-3 py-2">
    @error('saldo_awal')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Keterangan (opsional)</label>
    <input name="keterangan" value="{{ old('keterangan', $dompet->keterangan ?? '') }}" class="w-full border rounded px-3 py-2">
  </div>
  <div class="flex gap-2">
    <button class="px-4 py-2 border rounded">Simpan</button>
    <a class="px-4 py-2 border rounded" href="{{ route('dompet.index') }}">Batal</a>
  </div>
</div>

@csrf
<div class="grid gap-4 card">
  <div>
    <label class="block text-sm mb-1 text-slate-700">Nama Dompet</label>
    <input name="nama_dompet" value="{{ old('nama_dompet', $dompet->nama_dompet ?? '') }}" class="input">
    @error('nama_dompet')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">Jenis Dompet</label>
    <select name="jenis_dompet" class="select">
      @foreach(['tunai','bank','e-wallet'] as $opt)
        <option value="{{ $opt }}" @selected(old('jenis_dompet', $dompet->jenis_dompet ?? '') === $opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('jenis_dompet')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">Saldo Awal</label>
    <input type="number" step="0.01" min="0" name="saldo_awal" value="{{ old('saldo_awal', $dompet->saldo_awal ?? 0) }}" class="input">
    @error('saldo_awal')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1 text-slate-700">Keterangan (opsional)</label>
    <input name="keterangan" value="{{ old('keterangan', $dompet->keterangan ?? '') }}" class="input">
  </div>
  <div class="flex gap-2">
    <button class="btn-primary">Simpan</button>
    <a class="btn-ghost" href="{{ route('dompet.index') }}">Batal</a>
  </div>
</div>

@csrf
<div class="grid gap-4 card-soft">
  <div>
    <label class="block text-sm mb-1">Nama Dompet</label>
    <input name="nama_dompet" class="input" value="{{ old('nama_dompet', $dompet->nama_dompet ?? '') }}">
    @error('nama_dompet')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Jenis Dompet</label>
    <select name="jenis_dompet" class="select">
      @foreach(['tunai','bank','e-wallet'] as $opt)
        <option value="{{ $opt }}" @selected(old('jenis_dompet', $dompet->jenis_dompet ?? '')===$opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('jenis_dompet')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Saldo Awal</label>
    <input type="number" step="0.01" min="0" name="saldo_awal" class="input" value="{{ old('saldo_awal', $dompet->saldo_awal ?? 0) }}">
    @error('saldo_awal')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Keterangan (opsional)</label>
    <input name="keterangan" class="input" value="{{ old('keterangan', $dompet->keterangan ?? '') }}">
  </div>

  <div class="flex gap-2 justify-end">
    <button class="btn-primary">Simpan</button>
    <a href="{{ route('dompet.index') }}" class="btn-ghost">Batal</a>
  </div>
</div>

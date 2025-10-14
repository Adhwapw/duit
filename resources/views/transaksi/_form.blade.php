@csrf
<div class="grid gap-4 card">
  <div>
    <label class="block text-sm mb-1 text-slate-700">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', ($transaksi->tanggal ?? now()->toDateString()) ) }}" class="input">
    @error('tanggal')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm mb-1 text-slate-700">Jenis</label>
    <select id="form-jenis" name="jenis" class="select">
      @foreach(['pemasukan','pengeluaran'] as $opt)
        <option value="{{ $opt }}" @selected(old('jenis', $transaksi->jenis ?? '') === $opt)>{{ $opt }}</option>
      @endforeach
    </select>
    @error('jenis')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm mb-1 text-slate-700">Jumlah</label>
    <input type="number" step="0.01" min="0.01" name="jumlah" value="{{ old('jumlah', $transaksi->jumlah ?? '') }}" class="input" placeholder="0.00">
    @error('jumlah')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm mb-1 text-slate-700">Dompet</label>
    <select name="dompet_id" class="select">
      @foreach($dompet as $d)
        <option value="{{ $d->id }}" @selected(old('dompet_id', $transaksi->dompet_id ?? '') == $d->id)>{{ $d->nama_dompet }}</option>
      @endforeach
    </select>
    @error('dompet_id')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm mb-1 text-slate-700">Kategori</label>
    <select id="form-kategori" name="kategori_id" class="select">
      @foreach($kategori as $k)
        <option value="{{ $k->id }}" data-tipe="{{ $k->tipe }}" @selected(old('kategori_id', $transaksi->kategori_id ?? '') == $k->id)>
          {{ $k->nama_kategori }} ({{ $k->tipe }})
        </option>
      @endforeach
    </select>
    @error('kategori_id')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm mb-1 text-slate-700">Catatan (opsional)</label>
    <input name="catatan" value="{{ old('catatan', $transaksi->catatan ?? '') }}" class="input" placeholder="mis. makan siang / gaji bulanan">
  </div>

  <div class="flex gap-2">
    <button class="btn-primary">Simpan</button>
    <a class="btn-ghost" href="{{ route('transaksi.index') }}">Batal</a>
  </div>
</div>

{{-- Filter kategori by jenis (client-side) --}}
<script>
  (function(){
    const jenisSel = document.getElementById('form-jenis');
    const katSel   = document.getElementById('form-kategori');
    if (!jenisSel || !katSel) return;
    const allOpts  = Array.from(katSel.options).map(o => ({value:o.value,text:o.text, tipe:o.dataset.tipe}));

    function renderByJenis() {
      const want = jenisSel.value;
      const selected = katSel.value;
      katSel.innerHTML = '';
      const candidates = allOpts.filter(o => o.tipe === want);
      candidates.forEach(o => {
        const opt = document.createElement('option');
        opt.value = o.value; opt.textContent = o.text; opt.dataset.tipe = o.tipe;
        if (o.value === selected) opt.selected = true;
        katSel.appendChild(opt);
      });
      if (!katSel.value && candidates[0]) katSel.value = candidates[0].value;
    }
    jenisSel.addEventListener('change', renderByJenis);
    // initial render, tapi hanya jika opsi awal mismatch
    const hasMatch = allOpts.some(o => o.value === katSel.value && o.tipe === jenisSel.value);
    if (!hasMatch) renderByJenis();
  })();
</script>

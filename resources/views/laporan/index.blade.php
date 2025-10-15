@extends('layouts.app')

@section('content')
<x-page-header title="Laporan" subtitle="Filter tanggal untuk melihat ringkasan & detail">
  <a href="{{ route('laporan.unduh', ['awal'=>$awal,'akhir'=>$akhir]) }}" class="btn-ghost"
     @disabled(!$awal || !$akhir)>
    {{-- download icon --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3v10.19l3.3-3.3 1.4 1.42L12 16.99l-4.7-4.7 1.4-1.42 3.3 3.3V3h2Z"/><path d="M4 18h16v2H4z"/></svg>
    Unduh CSV
  </a>
</x-page-header>

<form method="GET" class="card section grid grid-cols-1 sm:grid-cols-3 gap-3 items-end mb-6">
  <div>
    <label class="block text-sm mb-1">Tanggal Awal</label>
    <input type="date" name="awal" value="{{ $awal }}" class="input">
  </div>
  <div>
    <label class="block text-sm mb-1">Tanggal Akhir</label>
    <input type="date" name="akhir" value="{{ $akhir }}" class="input">
  </div>
  <div class="flex gap-2">
    <button class="btn-ghost">Terapkan</button>
    <a href="{{ route('laporan.index') }}" class="btn-ghost">Reset</a>
  </div>
</form>

{{-- Ringkasan angka --}}
<div class="section grid grid-cols-1 md:grid-cols-3 gap-4">
  <x-kartu variant="green" title="Total Pemasukan" :value="number_format($ringkas['pemasukan'] ?? 0,2,',','.')" />
  <x-kartu variant="blue"  title="Total Pengeluaran" :value="number_format($ringkas['pengeluaran'] ?? 0,2,',','.')" />
  <x-kartu variant="brand" title="Saldo Bersih" :value="number_format($ringkas['saldo_bersih'] ?? 0,2,',','.')" />
</div>

{{-- Tabel hasil --}}
<x-tabel>
  <thead>
    <tr>
      <th class="th">Tanggal</th>
      <th class="th">Jenis</th>
      <th class="th">Dompet</th>
      <th class="th">Kategori</th>
      <th class="th text-right">Jumlah</th>
      <th class="th">Catatan</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $t)
      <tr class="tr-hover">
        <td class="td">{{ $t->tanggal }}</td>
        <td class="td">
          @if($t->jenis==='pemasukan')
            <span class="inline-block rounded-full bg-green-50 text-green-700 px-2 py-0.5 text-xs">pemasukan</span>
          @else
            <span class="inline-block rounded-full bg-rose-50 text-rose-700 px-2 py-0.5 text-xs">pengeluaran</span>
          @endif
        </td>
        <td class="td">{{ $t->dompet?->nama_dompet }}</td>
        <td class="td">{{ $t->kategori?->nama_kategori }}</td>
        <td class="td text-right font-semibold">{{ number_format($t->jumlah,2,',','.') }}</td>
        <td class="td">{{ $t->catatan }}</td>
      </tr>
    @empty
      <tr><td class="td" colspan="6">Tidak ada data untuk rentang tanggal ini.</td></tr>
    @endforelse
  </tbody>
</x-tabel>
@endsection

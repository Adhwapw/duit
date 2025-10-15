@extends('layouts.app')

@section('content')
<x-page-header title="Transaksi" subtitle="Kelola catatan pemasukan & pengeluaran">
  <a href="{{ route('transaksi.create') }}" class="btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 5h2v14h-2V5ZM5 11h14v2H5v-2Z"/></svg>
    Tambah
  </a>
</x-page-header>

<form method="GET" class="card section grid grid-cols-1 md:grid-cols-5 gap-3 items-end mb-6">
  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Cari (catatan/dompet/kategori)</label>
    <input class="input" type="text" name="q" value="{{ $q }}">
  </div>
  <div>
    <label class="block text-sm mb-1">Jenis</label>
    <select name="jenis" class="select">
      <option value="">-- semua --</option>
      <option value="pemasukan" {{ $jenis==='pemasukan'?'selected':'' }}>pemasukan</option>
      <option value="pengeluaran" {{ $jenis==='pengeluaran'?'selected':'' }}>pengeluaran</option>
    </select>
  </div>
  <div>
    <label class="block text-sm mb-1">Tanggal Awal</label>
    <input class="input" type="date" name="awal" value="{{ $awal }}">
  </div>
  <div>
    <label class="block text-sm mb-1">Tanggal Akhir</label>
    <input class="input" type="date" name="akhir" value="{{ $akhir }}">
  </div>
  <div class="md:col-span-5 flex gap-2">
    <button class="btn-ghost">Terapkan</button>
    <a href="{{ route('transaksi.index') }}" class="btn-ghost">Reset</a>
  </div>
</form>

<x-tabel>
  <thead>
    <tr>
      <th class="th">Tanggal</th>
      <th class="th">Jenis</th>
      <th class="th">Dompet</th>
      <th class="th">Kategori</th>
      <th class="th text-right">Jumlah</th>
      <th class="th">Catatan</th>
      <th class="th text-right">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $t)
    <tr class="tr-hover">
      <td class="td">{{ $t->tanggal }}</td>
      <td class="td">
        @if($t->jenis==='pemasukan') <span class="inline-block rounded-full bg-green-50 text-green-700 px-2 py-0.5 text-xs">pemasukan</span>
        @else <span class="inline-block rounded-full bg-rose-50 text-rose-700 px-2 py-0.5 text-xs">pengeluaran</span>
        @endif
      </td>
      <td class="td">{{ $t->dompet?->nama_dompet }}</td>
      <td class="td">{{ $t->kategori?->nama_kategori }}</td>
      <td class="td text-right font-semibold">{{ number_format($t->jumlah,2,',','.') }}</td>
      <td class="td">{{ $t->catatan }}</td>
      <td class="td text-right">
        <a class="link" href="{{ route('transaksi.edit',$t) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('transaksi.destroy',$t) }}">
          @csrf @method('DELETE')
          <button class="btn-danger ml-2">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td class="td" colspan="7">Tidak ada data untuk filter ini.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="section">{{ $items->withQueryString()->links() }}</div>
@endsection

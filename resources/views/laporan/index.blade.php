@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Laporan Keuangan</h1>

<form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
  <div>
    <label class="block text-sm mb-1">Tanggal Awal</label>
    <input type="date" name="awal" value="{{ $awal }}" class="w-full border rounded px-3 py-2">
  </div>
  <div>
    <label class="block text-sm mb-1">Tanggal Akhir</label>
    <input type="date" name="akhir" value="{{ $akhir }}" class="w-full border rounded px-3 py-2">
  </div>
  <div class="flex items-end">
    <button class="px-4 py-2 border rounded">Terapkan</button>
  </div>
  <div class="flex items-end">
    <a class="px-4 py-2 border rounded" href="{{ route('laporan.unduh', request()->only('awal','akhir')) }}">Unduh CSV</a>
  </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <x-kartu title="Total Pemasukan" :value="number_format($pemasukan,2,',','.')" />
  <x-kartu title="Total Pengeluaran" :value="number_format($pengeluaran,2,',','.')" />
  <x-kartu title="Saldo Bersih" :value="number_format($saldoBersih,2,',','.')" />
</div>

<x-tabel>
  <thead class="bg-gray-50">
    <tr>
      <th class="text-left p-2">Tanggal</th>
      <th class="text-left p-2">Jenis</th>
      <th class="text-left p-2">Dompet</th>
      <th class="text-left p-2">Kategori</th>
      <th class="text-right p-2">Jumlah</th>
      <th class="text-left p-2">Catatan</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $t)
    <tr class="border-t">
      <td class="p-2">{{ $t->tanggal }}</td>
      <td class="p-2">{{ $t->jenis }}</td>
      <td class="p-2">{{ $t->dompet?->nama_dompet }}</td>
      <td class="p-2">{{ $t->kategori?->nama_kategori }}</td>
      <td class="p-2 text-right">{{ number_format($t->jumlah,2,',','.') }}</td>
      <td class="p-2">{{ $t->catatan }}</td>
    </tr>
    @empty
    <tr><td class="p-3" colspan="6">Belum ada data pada rentang ini.</td></tr>
    @endforelse
  </tbody>
</x-tabel>
@endsection

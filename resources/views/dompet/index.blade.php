@extends('layouts.app')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-semibold">Dompet</h1>
  <a href="{{ route('dompet.create') }}" class="px-3 py-2 border rounded">Tambah</a>
</div>

<x-tabel>
  <thead class="bg-gray-50">
    <tr>
      <th class="text-left p-2">Nama</th>
      <th class="text-left p-2">Jenis</th>
      <th class="text-right p-2">Saldo Awal</th>
      <th class="text-right p-2">Sisa Saldo</th> {{-- ← kolom baru --}}
      <th class="text-left p-2">Keterangan</th>
      <th class="p-2"></th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $d)
    @php
      $pemasukan   = (float)($d->total_pemasukan ?? 0);
      $pengeluaran = (float)($d->total_pengeluaran ?? 0);
      $sisa        = (float)$d->saldo_awal + $pemasukan - $pengeluaran;
    @endphp
    <tr class="border-t">
      <td class="p-2">{{ $d->nama_dompet }}</td>
      <td class="p-2">{{ $d->jenis_dompet }}</td>
      <td class="p-2 text-right">{{ number_format($d->saldo_awal,2,',','.') }}</td>
      <td class="p-2 text-right">{{ number_format($sisa,2,',','.') }}</td> {{-- ← nilai baru --}}
      <td class="p-2">{{ $d->keterangan }}</td>
      <td class="p-2 text-right">
        <a class="px-2 py-1 border rounded" href="{{ route('dompet.edit',$d) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('dompet.destroy',$d) }}">
          @csrf @method('DELETE')
          <button class="px-2 py-1 border rounded" onclick="return confirm('Hapus dompet?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td class="p-3" colspan="6">Belum ada data.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="mt-4">{{ $items->links() }}</div>
@endsection

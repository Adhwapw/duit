@extends('layouts.app')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-semibold">Transaksi</h1>
  <a href="{{ route('transaksi.create') }}" class="px-3 py-2 border rounded">Tambah</a>
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
      <th class="p-2"></th>
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
      <td class="p-2 text-right">
        <a class="px-2 py-1 border rounded" href="{{ route('transaksi.edit',$t) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('transaksi.destroy',$t) }}">
          @csrf @method('DELETE')
          <button class="px-2 py-1 border rounded" onclick="return confirm('Hapus transaksi?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td class="p-3" colspan="7">Belum ada data.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="mt-4">{{ $items->links() }}</div>
@endsection

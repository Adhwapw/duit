@extends('layouts.app')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-semibold">Kategori</h1>
  <a href="{{ route('kategori.create') }}" class="px-3 py-2 border rounded">Tambah</a>
</div>

<x-tabel>
  <thead class="bg-gray-50">
    <tr>
      <th class="text-left p-2">Nama</th>
      <th class="text-left p-2">Tipe</th>
      <th class="text-left p-2">Warna</th>
      <th class="p-2"></th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $k)
    <tr class="border-t">
      <td class="p-2">{{ $k->nama_kategori }}</td>
      <td class="p-2">{{ $k->tipe }}</td>
      <td class="p-2">{{ $k->warna_opsional }}</td>
      <td class="p-2 text-right">
        <a class="px-2 py-1 border rounded" href="{{ route('kategori.edit',$k) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('kategori.destroy',$k) }}">
          @csrf @method('DELETE')
          <button class="px-2 py-1 border rounded" onclick="return confirm('Hapus kategori?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td class="p-3" colspan="4">Belum ada data.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="mt-4">{{ $items->links() }}</div>
@endsection

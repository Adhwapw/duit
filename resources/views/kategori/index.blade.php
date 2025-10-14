@extends('layouts.app')
@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-semibold">Kategori</h1>
  <a href="{{ route('kategori.create') }}" class="btn-primary">Tambah</a>
</div>

<x-tabel>
  <thead>
    <tr>
      <th class="th">Nama</th>
      <th class="th">Tipe</th>
      <th class="th">Warna</th>
      <th class="th text-right">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $k)
    <tr>
      <td class="td">{{ $k->nama_kategori }}</td>
      <td class="td">
        @if($k->tipe === 'pemasukan')
          <span class="pill pill-green">pemasukan</span>
        @else
          <span class="pill pill-rose">pengeluaran</span>
        @endif
      </td>
      <td class="td">
        @if($k->warna_opsional)
          <span class="inline-flex items-center gap-2">
            <span class="w-3 h-3 rounded-full" style="background: {{ $k->warna_opsional }}"></span>
            <span class="text-slate-600 text-xs">{{ $k->warna_opsional }}</span>
          </span>
        @else
          <span class="text-slate-400 text-xs">—</span>
        @endif
      </td>
      <td class="td text-right">
        <a class="btn-ghost" href="{{ route('kategori.edit',$k) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('kategori.destroy',$k) }}">
          @csrf @method('DELETE')
          <button class="btn-danger" onclick="return confirm('Hapus kategori?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td class="td" colspan="4">Belum ada data.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="mt-4">{{ $items->links() }}</div>
@endsection

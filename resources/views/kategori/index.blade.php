@extends('layouts.app')

@section('content')
<x-page-header title="Kategori" subtitle="Kelompokkan transaksi Anda">
  <a href="{{ route('kategori.create') }}" class="btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 5h2v14h-2V5ZM5 11h14v2H5v-2Z"/></svg>
    Tambah
  </a>
</x-page-header>

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
    <tr class="tr-hover">
      <td class="td">{{ $k->nama_kategori }}</td>
      <td class="td">
        @if($k->tipe === 'pemasukan')
          <span class="inline-block rounded-full bg-green-50 text-green-700 px-2 py-0.5 text-xs">pemasukan</span>
        @else
          <span class="inline-block rounded-full bg-rose-50 text-rose-700 px-2 py-0.5 text-xs">pengeluaran</span>
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
        <a class="link" href="{{ route('kategori.edit',$k) }}">Edit</a>
        <form class="inline" method="POST" action="{{ route('kategori.destroy',$k) }}">
          @csrf @method('DELETE')
          <button class="btn-danger ml-2">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
      <tr><td class="td" colspan="4">Belum ada data.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="section">{{ $items->links() }}</div>
@endsection

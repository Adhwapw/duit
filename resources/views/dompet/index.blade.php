@extends('layouts.app')

@section('content')
<x-page-header title="Dompet" subtitle="Daftar dompet milik Anda">
  <a href="{{ route('dompet.create') }}" class="btn-primary">
    {{-- plus icon --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 5h2v14h-2V5ZM5 11h14v2H5v-2Z"/></svg>
    Tambah
  </a>
</x-page-header>

<x-tabel>
  <thead>
    <tr>
      <th class="th">Nama</th>
      <th class="th">Jenis</th>
      <th class="th text-right">Saldo Awal</th>
      <th class="th text-right">Sisa Saldo</th>
      <th class="th">Keterangan</th>
      <th class="th text-right">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $d)
      @php
        $pemasukan   = (float)($d->total_pemasukan ?? 0);
        $pengeluaran = (float)($d->total_pengeluaran ?? 0);
        $sisa        = (float)$d->saldo_awal + $pemasukan - $pengeluaran;
      @endphp
      <tr class="tr-hover">
        <td class="td">{{ $d->nama_dompet }}</td>
        <td class="td">
          <span class="inline-block rounded-full px-2 py-0.5 text-xs
            {{ $d->jenis_dompet==='tunai' ? 'bg-green-50 text-green-700' :
               ($d->jenis_dompet==='bank' ? 'bg-sky-50 text-sky-700' : 'bg-violet-50 text-violet-700') }}">
            {{ $d->jenis_dompet }}
          </span>
        </td>
        <td class="td text-right">{{ number_format($d->saldo_awal,2,',','.') }}</td>
        <td class="td text-right font-semibold">{{ number_format($sisa,2,',','.') }}</td>
        <td class="td">{{ $d->keterangan }}</td>
        <td class="td text-right">
          <a class="link" href="{{ route('dompet.edit',$d) }}">Edit</a>
          <form class="inline" method="POST" action="{{ route('dompet.destroy',$d) }}">
            @csrf @method('DELETE')
            <button class="btn-danger ml-2">Hapus</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td class="td" colspan="6">Belum ada data.</td></tr>
    @endforelse
  </tbody>
</x-tabel>

<div class="section">{{ $items->links() }}</div>
@endsection

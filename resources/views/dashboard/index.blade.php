@extends('layouts.app')

@section('content')
<x-page-header title="Dashboard" subtitle="Ringkasan kondisi keuangan bulan ini">
  <a href="{{ route('transaksi.create') }}" class="btn-primary">
    {{-- icon plus --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 5h2v14h-2V5ZM5 11h14v2H5v-2Z"/></svg>
    Transaksi
  </a>
</x-page-header>

{{-- KPI Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <x-kartu variant="brand" title="Total Saldo Saat Ini" :value="number_format($totalSaldo,2,',','.')" />
  <x-kartu variant="green" title="Pemasukan Bulan Ini" :value="number_format($pemasukanBulan,2,',','.')" />
  <x-kartu variant="blue"  title="Pengeluaran Bulan Ini" :value="number_format($pengeluaranBulan,2,',','.')" />
</div>

{{-- Quick Nav --}}
<div class="section grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
  <a href="{{ route('transaksi.create') }}" class="card-soft hover:shadow-lg transition">
    <div class="muted text-sm flex items-center gap-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 5h2v14h-2V5ZM5 11h14v2H5v-2Z"/></svg>
      Aksi cepat
    </div>
    <div class="text-lg font-semibold mt-1">Tambah Transaksi</div>
  </a>
  <a href="{{ route('dompet.index') }}" class="card-soft-blue hover:shadow-lg transition">
    <div class="muted text-sm">Kelola</div><div class="text-lg font-semibold mt-1">Dompet</div>
  </a>
  <a href="{{ route('kategori.index') }}" class="card-soft-amber hover:shadow-lg transition">
    <div class="muted text-sm">Kelola</div><div class="text-lg font-semibold mt-1">Kategori</div>
  </a>
  <a href="{{ route('laporan.index') }}" class="card-soft-violet hover:shadow-lg transition">
    <div class="muted text-sm">Lihat</div><div class="text-lg font-semibold mt-1">Laporan</div>
  </a>
</div>

{{-- Saldo per Dompet --}}
@if($dompetRingkas->count())
  <div class="section card">
    <h2 class="text-lg font-semibold mb-3">Saldo per Dompet</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($dompetRingkas as $d)
        <div class="card-soft hover:shadow-lg transition">
          <div class="muted text-sm">{{ $d['jenis'] }}</div>
          <div class="text-base font-medium">{{ $d['nama'] }}</div>
          <div class="mt-1 text-2xl font-bold">{{ number_format($d['sisa_saldo'],2,',','.') }}</div>
        </div>
      @endforeach
    </div>
  </div>
@endif

{{-- Grafik --}}
<div class="section card">
  <h2 class="text-lg font-semibold mb-3">Grafik per Kategori (Bulan Berjalan)</h2>
  <canvas id="chartKat" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = @json(collect($dataKategori)->pluck('nama'));
  const dataVals = @json(collect($dataKategori)->pluck('total'));
  const colors = ['#14b8a6','#22c55e','#60a5fa','#06b6d4','#f59e0b','#8b5cf6','#ef4444'];

  new Chart(document.getElementById('chartKat'), {
    type: 'bar',
    data: { labels, datasets: [{ data: dataVals, backgroundColor: labels.map((_,i)=>colors[i%colors.length]), borderRadius: 12, borderSkipped: false }] },
    options: { plugins:{legend:{display:false}}, scales:{ y:{beginAtZero:true, ticks:{precision:0} } } }
  });
</script>
@endsection

@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <x-kartu title="Total Saldo Saat Ini" :value="number_format($totalSaldo,2,',','.')" />
  <x-kartu title="Pemasukan Bulan Ini" :value="number_format($pemasukanBulan,2,',','.')" />
  <x-kartu title="Pengeluaran Bulan Ini" :value="number_format($pengeluaranBulan,2,',','.')" />
</div>

<div class="mt-8">
  <h2 class="text-lg font-semibold mb-2">Grafik per Kategori (Bulan Berjalan)</h2>
  <canvas id="chartKat" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = @json(collect($dataKategori)->pluck('nama'));
  const data = @json(collect($dataKategori)->pluck('total'));
  new Chart(document.getElementById('chartKat'), {
    type: 'bar',
    data: { labels, datasets: [{ label: 'Jumlah', data }] },
    options: { scales: { y: { beginAtZero: true } } }
  });
</script>
@endsection

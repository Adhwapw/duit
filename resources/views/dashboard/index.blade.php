@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <x-kartu title="Total Saldo Saat Ini" :value="number_format($totalSaldo,2,',','.')" />
  <x-kartu title="Pemasukan Bulan Ini" :value="number_format($pemasukanBulan,2,',','.')" />
  <x-kartu title="Pengeluaran Bulan Ini" :value="number_format($pengeluaranBulan,2,',','.')" />
</div>

@if($dompetRingkas->count())
  <div class="mt-6 card">
    <h2 class="text-lg font-semibold mb-3">Saldo per Dompet</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($dompetRingkas as $d)
        <div class="surface p-4 hover:shadow-xl transition">
          <div class="text-sm text-slate-500">{{ $d['jenis'] }}</div>
          <div class="text-base font-medium">{{ $d['nama'] }}</div>
          <div class="mt-1 text-2xl font-bold">{{ number_format($d['sisa_saldo'],2,',','.') }}</div>
        </div>
      @endforeach
    </div>
  </div>
@endif

<div class="mt-6 card">
  <h2 class="text-lg font-semibold mb-3">Grafik per Kategori (Bulan Berjalan)</h2>
  <canvas id="chartKat" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = @json(collect($dataKategori)->pluck('nama'));
  const dataVals = @json(collect($dataKategori)->pluck('total'));

  // palet ala Googley
  const colors = [
    '#6366f1', '#06b6d4', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#14b8a6'
  ];

  new Chart(document.getElementById('chartKat'), {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Jumlah',
        data: dataVals,
        backgroundColor: labels.map((_, i) => colors[i % colors.length]),
        borderRadius: 12,
        borderSkipped: false,
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } }
      }
    }
  });
</script>
@endsection

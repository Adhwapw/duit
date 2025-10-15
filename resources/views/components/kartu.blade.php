@props(['title'=>'','value'=>'','variant'=>'brand'])
@php
  $map = [
    'brand' => 'card card-grad-brand',
    'green' => 'card card-grad-green',
    'blue'  => 'card card-grad-blue',
    'soft'  => 'card-soft',
    'soft-blue'  => 'card-soft-blue',
    'soft-amber' => 'card-soft-amber',
    'soft-violet'=> 'card-soft-violet',
  ];
  $cls = $map[$variant] ?? $map['brand'];
@endphp
<div {{ $attributes->merge(['class'=> $cls.' hover:shadow-lg transition']) }}>
  <div class="kpi-title">{{ $title }}</div>
  <div class="kpi-value">{{ $value }}</div>
</div>

@props(['title'=>'','subtitle'=>null])
<div class="page-header">
  <div>
    <h1 class="page-title">{{ $title }}</h1>
    @if($subtitle)<p class="page-sub">{{ $subtitle }}</p>@endif
  </div>
  <div class="flex gap-2">{{ $slot }}</div>
</div>

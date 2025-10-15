@props(['label' => 'Menu'])
<div class="relative">
  <button class="btn-ghost" x-data @click="$refs.menu.classList.toggle('hidden')">{{ $label }}</button>
  <div x-ref="menu" class="hidden absolute right-0 mt-2 w-48 surface p-2 z-50">
    {{ $slot }}
  </div>
</div>

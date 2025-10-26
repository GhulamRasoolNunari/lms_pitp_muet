@props(['value' => null])

<input
  type="checkbox"
  value="{{ $value }}"
  wire:key="chk-{{ $value }}"
  x-bind:checked="has($el.value)"
  @change="toggle($el.value, $el.checked)"
  class="rounded border-gray-300 text-rose-600 focus:ring-rose-500"
/>

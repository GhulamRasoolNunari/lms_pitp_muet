@props(['ids' => []])

<input
  type="checkbox"
  x-init="$el._ids = @js($ids)"
  x-bind:checked="($el._ids ?? []).length && ($el._ids ?? []).every(id => has(id))"
  x-ref="sa"
  x-effect="
    const list = $el._ids ?? [];
    const selOnPage = list.filter(id => has(id));
    $refs.sa.indeterminate = selOnPage.length > 0 && selOnPage.length < list.length;
  "
  @change="bulkSet(($el._ids ?? []), $el.checked)"
  class="rounded border-gray-300 text-rose-600 focus:ring-rose-500"
/>

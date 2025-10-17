@props([
    'method' => 'delete',
    'payload' => null,

    // UI text
    'tooltip' => 'Delete',
    'ariaLabel' => null,

    // SweetAlert options
    'confirmTitle' => 'Are you sure?',
    'confirmText' => 'Do you really want to delete this item?',
    'confirmButtonText' => 'Yes, delete it',
    'cancelButtonText' => 'Cancel',
    'confirmIcon' => 'warning',
    'confirmButtonColor' => '#e11d48',
    'cancelButtonColor' => '#3b82f6',
])

@php
    $aria = $ariaLabel ?? $tooltip;
@endphp

<div
    x-data="{
        showTooltip: false,
        method: @js($method),
        payload: @js($payload), // null if not provided
        confirm() {
            Swal.fire({
                title: @js($confirmTitle),
                text: @js($confirmText),
                icon: @js($confirmIcon),
                showCancelButton: true,
                confirmButtonText: @js($confirmButtonText),
                cancelButtonText: @js($cancelButtonText),
                confirmButtonColor: @js($confirmButtonColor),
                cancelButtonColor: @js($cancelButtonColor),
            }).then((result) => {
                if (result.isConfirmed) {
                    if (this.payload === null || typeof this.payload === 'undefined') {
                        $wire.call(this.method);
                    } else {
                        $wire.call(this.method, this.payload);
                    }
                }
            });
        }
    }"
    class="relative"
>
    <button
        type="button"
        @mouseenter="showTooltip = true"
        @mouseleave="showTooltip = false"
        @click="confirm()"
        class="group relative inline-flex items-center justify-center w-9 h-9 text-red-500 hover:bg-red-500/10 rounded-full transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
        aria-label="{{ $aria }}"
        title="{{ $tooltip }}"
    >
        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>

    <div
        x-show="showTooltip"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute z-10 bottom-full mb-2 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-gray-900 text-white text-sm rounded-md shadow-md whitespace-nowrap"
    >
        {{ $tooltip }}
    </div>
</div>

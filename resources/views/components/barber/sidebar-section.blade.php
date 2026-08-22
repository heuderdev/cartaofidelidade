@props([
    'title',
])

<div>
    <p class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-gray-500">
        {{ $title }}
    </p>

    <ul class="space-y-1">
        {{ $slot }}
    </ul>
</div>

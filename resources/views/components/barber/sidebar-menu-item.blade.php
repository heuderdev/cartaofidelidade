@props([
    'label',
    'href' => '#',
    'active' => false,
])

<li>
    <a
        href="{{ $href }}"
        {{ $attributes->class([
            'group flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition',
            'bg-[#c99b5b] font-semibold text-[#171717]' => $active,
            'text-gray-300 hover:bg-white/10 hover:text-white' => ! $active,
        ]) }}
    >
        <span
            @class([
                'shrink-0',
                'text-[#171717]' => $active,
                'text-gray-500 group-hover:text-[#c99b5b]' => ! $active,
            ])
        >
            {{ $slot }}
        </span>

        <span>
            {{ $label }}
        </span>
    </a>
</li>

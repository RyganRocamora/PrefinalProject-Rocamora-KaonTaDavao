@props(['rating' => 0])

@php
    $rounded = (int) round((float) $rating);
@endphp

<span class="inline-flex items-center text-amber-500" aria-label="Rating: {{ number_format((float) $rating, 1) }} out of 5">
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $rounded)
            <span class="text-base leading-none">&#9733;</span>
        @else
            <span class="text-base leading-none text-slate-300">&#9733;</span>
        @endif
    @endfor
</span>
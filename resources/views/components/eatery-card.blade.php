@props(['eatery'])

@php
    $priceLabels = [
        'budget' => '₱',
        'mid' => '₱₱',
        'splurge' => '₱₱₱',
    ];
    $priceDisplay = $priceLabels[$eatery->price_range] ?? '₱';
    $reviewCount = (int) ($eatery->reviews_count ?? 0);
    $avgRating = $eatery->reviews_avg_rating;
@endphp

<article class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between hover:border-amber-300 transition">
    <div>
        <div class="flex items-start justify-between gap-2 mb-2">
            <h3 class="text-lg font-bold text-slate-900 leading-snug">
                <a href="{{ route('eateries.show', $eatery) }}" class="hover:text-amber-700 transition">
                    {{ $eatery->name }}
                </a>
            </h3>

            @unless ($eatery->is_open)
                <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                    Closed
                </span>
            @endunless
        </div>

        <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('districts.show', $eatery->district) }}" class="font-medium text-amber-800 hover:underline">
                {{ $eatery->district->name }}
            </a>
            <span class="text-slate-300">&bull;</span>
            <span class="font-semibold text-emerald-700">{{ $priceDisplay }}</span>
        </div>

        @if ($eatery->specialty)
            <p class="text-sm text-slate-600 mb-3">
                <span class="font-medium text-slate-700">Specialty:</span> {{ $eatery->specialty }}
            </p>
        @endif

        @if ($eatery->features->isNotEmpty())
            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach ($eatery->features as $feature)
                    <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                       class="inline-block text-xs font-medium px-2.5 py-0.5 rounded-full bg-amber-100/80 text-amber-900 hover:bg-amber-200 transition">
                        {{ $feature->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
        @if ($reviewCount > 0)
            <div class="flex items-center gap-1.5">
                <x-rating :rating="$avgRating" />
                <span class="font-semibold text-slate-800">{{ number_format((float) $avgRating, 1) }}</span>
                <span class="text-slate-500">({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
            </div>
        @else
            <span class="text-slate-500 italic">No reviews yet</span>
        @endif

        <a href="{{ route('eateries.show', $eatery) }}" class="text-xs font-semibold text-amber-800 hover:underline">
            View &rarr;
        </a>
    </div>
</article>
@extends('layouts.app')

@section('content')
    @php
        $priceLabels = [
            'budget' => '₱ (Budget)',
            'mid' => '₱₱ (Mid-Range)',
            'splurge' => '₱₱₱ (Splurge)',
        ];
        $reviewCount = (int) ($eatery->reviews_count ?? 0);
        $avgRating = $eatery->reviews_avg_rating;
        $isPermitExpired = $eatery->permit && $eatery->permit->expires_on->isBefore(today());
    @endphp

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 mb-8">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 border-b border-slate-100 pb-6">
            <div>
                <div class="flex flex-wrap items-center gap-2.5 mb-2">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $eatery->name }}</h1>
                    @if ($eatery->is_open)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            Open
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                            Closed
                        </span>
                    @endif
                </div>

                <p class="text-sm text-slate-600">
                    District:
                    <a href="{{ route('districts.show', $eatery->district) }}" class="font-semibold text-amber-800 hover:underline">
                        {{ $eatery->district->name }}
                    </a>
                    &bull; {{ $eatery->address }}
                </p>

                <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-700">
                    <span class="font-semibold text-emerald-700">{{ $priceLabels[$eatery->price_range] ?? '₱' }}</span>
                    @if ($eatery->specialty)
                        <span>&bull; Specialty: <strong>{{ $eatery->specialty }}</strong></span>
                    @endif
                    <span>&bull;</span>
                    @if ($reviewCount > 0)
                        <span class="inline-flex items-center gap-1.5">
                            <x-rating :rating="$avgRating" />
                            <strong>{{ number_format((float) $avgRating, 1) }}</strong>
                            <span class="text-slate-500">({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
                        </span>
                    @else
                        <span class="text-slate-500 italic">No reviews yet</span>
                    @endif
                </div>

                @if ($eatery->features->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach ($eatery->features as $feature)
                            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                               class="text-xs font-medium px-3 py-1 rounded-full bg-amber-100 text-amber-900 hover:bg-amber-200 transition">
                                {{ $feature->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('eateries.edit', $eatery) }}"
                   class="px-4 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-sm font-semibold text-slate-700 transition">
                    Edit
                </a>

                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}"
                      onsubmit="return confirm('Delete this eatery and all its permit, dishes, and reviews?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Business Permit Box -->
        @if ($eatery->permit)
            <div class="mt-6 rounded-xl border {{ $isPermitExpired ? 'border-red-300 bg-red-50/70' : 'border-slate-200 bg-slate-50' }} p-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">City Business Permit</p>
                        <p class="text-base font-bold text-slate-900 mt-0.5">{{ $eatery->permit->permit_no }}</p>
                    </div>
                    <div class="text-sm">
                        <span class="text-slate-600">Expires on:</span>
                        <span class="font-semibold text-slate-900">{{ $eatery->permit->expires_on->format('F j, Y') }}</span>
                        @if ($isPermitExpired)
                            <span class="ml-2 font-bold text-red-600">Permit expired</span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Dishes Section -->
    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 mb-8">
        <h2 class="text-xl font-bold text-slate-900 mb-4">Menu &amp; Dishes</h2>

        @if ($eatery->dishes->isEmpty())
            <p class="text-sm text-slate-500">No dishes listed yet.</p>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($eatery->dishes as $dish)
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2.5">
                            <span class="font-medium text-slate-900">{{ $dish->name }}</span>
                            @if ($dish->is_bestseller)
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-900 border border-amber-200">
                                    Bestseller
                                </span>
                            @endif
                        </div>
                        <span class="font-bold text-emerald-700">₱{{ number_format((float) $dish->price, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Reviews & Review Form -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-xl font-bold text-slate-900">
                Reviews ({{ $reviewCount }})
            </h2>

            @if ($eatery->reviews->isEmpty())
                <div class="bg-white rounded-xl border border-slate-200 p-6 text-sm text-slate-600">
                    No reviews yet. Be the first to share your experience!
                </div>
            @else
                @foreach ($eatery->reviews as $review)
                    <article class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div>
                                <a href="{{ route('reviewers.show', $review->user) }}" class="font-bold text-slate-900 hover:text-amber-800 hover:underline">
                                    {{ $review->user->name }}
                                </a>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <x-rating :rating="$review->rating" />
                                    <span class="text-xs text-slate-500">{{ $review->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('reviews.destroy', $review) }}"
                                  onsubmit="return confirm('Delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>

                        <p class="text-sm text-slate-700 leading-relaxed mt-2">{{ $review->body }}</p>
                    </article>
                @endforeach
            @endif
        </div>

        <div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-3">Write a Review</h3>

                @if ($eatery->is_open)
                    @if ($errors->any())
                        <div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-3 text-xs text-red-700">
                            <p class="font-semibold mb-1">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="user_id" class="block text-sm font-medium text-slate-700 mb-1">Reviewer</label>
                            <select id="user_id" name="user_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                                <option value="">-- Select Reviewer --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected((string) old('user_id') === (string) $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="rating" class="block text-sm font-medium text-slate-700 mb-1">Rating (1–5 Stars)</label>
                            <select id="rating" name="rating" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                                <option value="">-- Select Rating --</option>
                                @for ($star = 5; $star >= 1; $star--)
                                    <option value="{{ $star }}" @selected((string) old('rating') === (string) $star)>
                                        {{ $star }} {{ $star === 1 ? 'Star' : 'Stars' }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="body" class="block text-sm font-medium text-slate-700 mb-1">Your Review</label>
                            <textarea id="body" name="body" rows="4"
                                      class="w-full rounded-lg border border-slate-300 p-3 text-sm"
                                      placeholder="Share what you ordered and how it tasted...">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full px-4 py-2.5 rounded-lg bg-amber-700 hover:bg-amber-800 text-white text-sm font-semibold transition">
                            Post Review
                        </button>
                    </form>
                @else
                    <p class="text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg p-4">
                        This eatery is closed. Reviews are paused.
                    </p>
                @endif
            </div>
        </div>
    </section>
@endsection
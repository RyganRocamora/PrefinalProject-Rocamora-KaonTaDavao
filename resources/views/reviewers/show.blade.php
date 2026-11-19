@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
        <h1 class="text-2xl font-extrabold text-slate-900">{{ $user->name }}</h1>
        <p class="text-sm font-medium text-slate-600 mt-1">
            {{ $user->reviews_count }} {{ $user->reviews_count === 1 ? 'review' : 'reviews' }} written
        </p>
    </div>

    @if ($user->reviews->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-6 text-sm text-slate-600">
            This reviewer has not written any reviews yet.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($user->reviews as $review)
                <article class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                        <a href="{{ route('eateries.show', $review->eatery) }}"
                           class="text-lg font-bold text-amber-800 hover:underline">
                            {{ $review->eatery->name }}
                        </a>
                        <div class="flex items-center gap-2">
                            <x-rating :rating="$review->rating" />
                            <span class="text-xs text-slate-500">{{ $review->created_at->format('M j, Y') }}</span>
                        </div>
                    </div>

                    <p class="text-sm text-slate-700 leading-relaxed">{{ $review->body }}</p>
                </article>
            @endforeach
        </div>
    @endif
@endsection
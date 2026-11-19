@extends('layouts.app')

@section('content')
    <section class="bg-white rounded-2xl border border-amber-200/80 p-6 sm:p-8 shadow-sm mb-8">
        <div class="max-w-3xl">
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-700 mb-2">Davao City Tourism Office</p>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">
                Discover Davao's Best Carinderias &amp; Local Eateries
            </h1>
            <p class="text-slate-600 text-sm sm:text-base mb-6">
                From steaming tinola in Poblacion to fresh kinilaw in Agdao and durian shakes after class—browse verified permits, bestsellers, and honest reviews from Davaoeños.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-xl bg-amber-50 border border-amber-200/70 p-4">
                <p class="text-sm font-medium text-amber-900">Eateries Listed</p>
                <p class="text-3xl font-extrabold text-amber-800 mt-1">{{ $eateryCount }}</p>
            </div>
            <div class="rounded-xl bg-amber-50 border border-amber-200/70 p-4">
                <p class="text-sm font-medium text-amber-900">Davao Districts</p>
                <p class="text-3xl font-extrabold text-amber-800 mt-1">{{ $districtCount }}</p>
            </div>
            <div class="rounded-xl bg-amber-50 border border-amber-200/70 p-4">
                <p class="text-sm font-medium text-amber-900">Resident Reviews</p>
                <p class="text-3xl font-extrabold text-amber-800 mt-1">{{ $reviewCount }}</p>
            </div>
        </div>
    </section>

    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-slate-900">Top Rated</h2>
            <a href="{{ route('eateries.index') }}" class="text-sm font-semibold text-amber-800 hover:underline">
                Browse all eateries &rarr;
            </a>
        </div>

        @if ($topEateries->isEmpty())
            <p class="text-slate-600 bg-white rounded-xl border border-slate-200 p-6">No rated eateries yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($topEateries as $eatery)
                    <x-eatery-card :eatery="$eatery" />
                @endforeach
            </div>
        @endif
    </section>
@endsection
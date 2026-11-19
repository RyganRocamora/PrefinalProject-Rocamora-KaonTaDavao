@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <a href="{{ route('districts.index') }}" class="text-sm font-medium text-amber-800 hover:underline">
            &larr; All Districts
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">{{ $district->name }}</h1>
        <p class="text-sm font-medium text-slate-600 mt-1">
            {{ $district->reviews_count }} {{ $district->reviews_count === 1 ? 'review' : 'reviews' }} in {{ $district->name }}
        </p>
    </div>

    @if ($eateries->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-6 text-slate-600">
            No eateries listed in {{ $district->name }} yet.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection
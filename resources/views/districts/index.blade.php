@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Davao City Districts</h1>
        <p class="text-sm text-slate-600">Select a district to view its listed eateries and resident reviews.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($districts as $district)
            <a href="{{ route('districts.show', $district) }}"
               class="block bg-white rounded-xl border border-slate-200 shadow-sm p-6 hover:border-amber-400 transition">
                <h2 class="text-lg font-bold text-slate-900">{{ $district->name }}</h2>
                <p class="text-sm text-amber-800 font-medium mt-1">
                    {{ $district->eateries_count }} {{ $district->eateries_count === 1 ? 'eatery' : 'eateries' }}
                </p>
            </a>
        @endforeach
    </div>
@endsection
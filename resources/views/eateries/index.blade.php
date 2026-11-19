@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Davao Eateries &amp; Carinderias</h1>
            <p class="text-sm text-slate-600">Ordered alphabetically (A–Z), 6 eateries per page.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('eateries.index') }}"
          class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label for="q" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-1">
                Search Name or Specialty
            </label>
            <input id="q" type="text" name="q" value="{{ $q }}" placeholder="e.g. Tinola, Rocamora..."
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
        </div>

        <div>
            <label for="district" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-1">
                District
            </label>
            <select id="district" name="district" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                <option value="">All Districts</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected((string) $districtId === (string) $district->id)>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="feature" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-1">
                Feature
            </label>
            <select id="feature" name="feature" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                <option value="">All Features</option>
                @foreach ($features as $feature)
                    <option value="{{ $feature->name }}" @selected($featureName === $feature->name)>
                        {{ $feature->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                    class="flex-1 px-4 py-2 rounded-lg bg-amber-700 hover:bg-amber-800 text-white text-sm font-semibold transition">
                Filter
            </button>
            <a href="{{ route('eateries.index') }}"
               class="px-3 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium">
                Reset
            </a>
        </div>
    </form>

    @if ($eateries->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-8 text-center text-slate-600 font-medium">
            No eateries match your filters.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $eateries->links() }}
        </div>
    @endif
@endsection
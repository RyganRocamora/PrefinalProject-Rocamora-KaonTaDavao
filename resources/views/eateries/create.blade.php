@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <h1 class="text-2xl font-extrabold text-slate-900 mb-6">Add New Eatery</h1>

        <form method="POST" action="{{ route('eateries.store') }}">
            @csrf
            @include('eateries._form')

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-amber-700 hover:bg-amber-800 text-white text-sm font-semibold transition">
                    Save Eatery
                </button>
                <a href="{{ route('eateries.index') }}" class="text-sm font-medium text-slate-600 hover:underline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
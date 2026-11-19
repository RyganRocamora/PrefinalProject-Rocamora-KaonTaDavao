@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-semibold mb-1">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $selectedFeatures = old('features', isset($eatery) ? $eatery->features->pluck('id')->all() : []);
    $isOpen = old('is_open', isset($eatery) ? $eatery->is_open : true);
    $expiryDefault = isset($eatery) && $eatery->permit ? $eatery->permit->expires_on->format('Y-m-d') : '';
@endphp

<div class="space-y-5">
    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Eatery Name</label>
        <input id="name" type="text" name="name" value="{{ old('name', $eatery->name ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
        @error('name')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- District & Price Range -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="district_id" class="block text-sm font-semibold text-slate-700 mb-1">District</label>
            <select id="district_id" name="district_id" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm bg-white">
                <option value="">-- Select District --</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}"
                        @selected((string) old('district_id', $eatery->district_id ?? '') === (string) $district->id)>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
            @error('district_id')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price_range" class="block text-sm font-semibold text-slate-700 mb-1">Price Range</label>
            <select id="price_range" name="price_range" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm bg-white">
                <option value="">-- Select Price Range --</option>
                <option value="budget" @selected(old('price_range', $eatery->price_range ?? '') === 'budget')>₱ — Budget</option>
                <option value="mid" @selected(old('price_range', $eatery->price_range ?? '') === 'mid')>₱₱ — Mid-Range</option>
                <option value="splurge" @selected(old('price_range', $eatery->price_range ?? '') === 'splurge')>₱₱₱ — Splurge</option>
            </select>
            @error('price_range')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Address -->
    <div>
        <label for="address" class="block text-sm font-semibold text-slate-700 mb-1">Street Address</label>
        <input id="address" type="text" name="address" value="{{ old('address', $eatery->address ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
        @error('address')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Specialty -->
    <div>
        <label for="specialty" class="block text-sm font-semibold text-slate-700 mb-1">Specialty Dish (Optional)</label>
        <input id="specialty" type="text" name="specialty" value="{{ old('specialty', $eatery->specialty ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
        @error('specialty')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Permit Number & Expiry Date -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
        <div>
            <label for="permit_no" class="block text-sm font-semibold text-slate-700 mb-1">Business Permit No.</label>
            <input id="permit_no" type="text" name="permit_no"
                   value="{{ old('permit_no', $eatery->permit->permit_no ?? '') }}"
                   placeholder="DVO-2026-0313"
                   class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
            @error('permit_no')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="expires_on" class="block text-sm font-semibold text-slate-700 mb-1">Permit Expiry Date</label>
            <input id="expires_on" type="date" name="expires_on"
                   value="{{ old('expires_on', $expiryDefault) }}"
                   class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
            @error('expires_on')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Features Checkboxes -->
    <div class="pt-2 border-t border-slate-100">
        <span class="block text-sm font-semibold text-slate-700 mb-2">Features (Pick at least 1)</span>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 bg-slate-50 px-3 py-2 rounded-lg border border-slate-200 cursor-pointer">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                           @checked(in_array($feature->id, array_map('intval', (array) $selectedFeatures)))>
                    <span>{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('features.*')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Is Open Checkbox -->
    <div class="pt-2 border-t border-slate-100">
        <label class="inline-flex items-center gap-2.5 text-sm font-medium text-slate-800 cursor-pointer">
            <input type="checkbox" name="is_open" value="1" @checked((bool) $isOpen)>
            <span>Currently Open for Customers</span>
        </label>
        @error('is_open')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
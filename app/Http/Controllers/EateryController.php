<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EateryController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->query('q');
        $districtId = $request->query('district');
        $featureName = $request->query('feature');

        $eateries = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($q, function ($query, $q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('specialty', 'like', "%{$q}%");
                });
            })
            ->when($districtId, function ($query, $districtId) {
                $query->where('district_id', $districtId);
            })
            ->when($featureName, function ($query, $featureName) {
                $query->whereHas('features', function ($subQuery) use ($featureName) {
                    $subQuery->where('name', $featureName);
                });
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact(
            'eateries',
            'districts',
            'features',
            'q',
            'districtId',
            'featureName'
        ));
    }

    public function create(): View
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    public function store(StoreEateryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $eatery = Eatery::create([
            'district_id' => $validated['district_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => $validated['is_open'],
        ]);

        $eatery->permit()->create([
            'permit_no' => $validated['permit_no'],
            'expires_on' => $validated['expires_on'],
        ]);

        $eatery->features()->sync($validated['features']);

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('status', 'Eatery added.');
    }

    public function show(Eatery $eatery): View
    {
        $eatery->load([
            'district',
            'permit',
            'features',
            'dishes',
            'reviews' => fn ($query) => $query->latest()->with('user'),
        ])->loadCount('reviews')->loadAvg('reviews', 'rating');

        $users = User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    public function edit(Eatery $eatery): View
    {
        $eatery->load(['permit', 'features']);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery): RedirectResponse
    {
        $validated = $request->validated();

        $eatery->update([
            'district_id' => $validated['district_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => $validated['is_open'],
        ]);

        $eatery->permit()->updateOrCreate(
            ['eatery_id' => $eatery->id],
            [
                'permit_no' => $validated['permit_no'],
                'expires_on' => $validated['expires_on'],
            ]
        );

        $eatery->features()->sync($validated['features']);

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('status', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery): RedirectResponse
    {
        $eatery->permit()->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()
            ->route('eateries.index')
            ->with('status', 'Eatery deleted.');
    }
}
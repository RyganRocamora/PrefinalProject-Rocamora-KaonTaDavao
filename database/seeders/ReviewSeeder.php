<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $myEatery = Eatery::where('slug', 'carinderia-ni-rocamora')->firstOrFail();
        $tita = User::where('email', 'tita.rocamora@kaonta.test')->firstOrFail();
        $rygan = User::where('email', 'rocamora@kaonta.test')->firstOrFail();
        $otherUsers = User::whereNotIn('id', [$tita->id, $rygan->id])->get();

        // Tita's exact 5-star review
        $myEatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Rocamora.',
        ]);

        // Two additional reviews on Carinderia ni Rocamora (at least 3 total)
        $myEatery->reviews()->create([
            'user_id' => $rygan->id,
            'rating' => 5,
            'body' => 'Fresh kaayo ang tinolang manok ug kinilaw diri sa Poblacion.',
        ]);

        $myEatery->reviews()->create([
            'user_id' => $otherUsers->random()->id,
            'rating' => 4,
            'body' => 'Sulit kaayo ang presyo sa durian shake ug rice meals!',
        ]);

        // Open factory eateries get 0-6 reviews; closed eateries get none
        $openFactoryEateries = Eatery::where('slug', '!=', 'carinderia-ni-rocamora')
            ->where('is_open', true)
            ->get();

        $allUserIds = User::pluck('id');

        foreach ($openFactoryEateries as $eatery) {
            $count = rand(0, 6);

            for ($i = 0; $i < $count; $i++) {
                Review::factory()->create([
                    'eatery_id' => $eatery->id,
                    'user_id' => $allUserIds->random(),
                ]);
            }
        }
    }
}
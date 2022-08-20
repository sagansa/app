<?php

namespace Database\Factories;

use App\Models\StoreAsset;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreAssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoreAsset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->numberBetween(1, 2),
            'notes' => $this->faker->text,
            'store_id' => \App\Models\Store::factory(),
        ];
    }
}

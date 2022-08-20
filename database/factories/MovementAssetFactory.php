<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\MovementAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementAssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovementAsset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'qr_code' => $this->faker->text(255),
            'good_cond_qty' => $this->faker->randomNumber(0),
            'bad_cond_qty' => $this->faker->randomNumber(0),
            'product_id' => \App\Models\Product::factory(),
            'store_asset_id' => \App\Models\StoreAsset::factory(),
        ];
    }
}

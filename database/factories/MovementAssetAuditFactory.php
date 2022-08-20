<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\MovementAssetAudit;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementAssetAuditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovementAssetAudit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => $this->faker->text(255),
            'good_cond_qty' => $this->faker->randomNumber(0),
            'bad_cond_qty' => $this->faker->randomNumber(0),
            'movement_asset_id' => \App\Models\MovementAsset::factory(),
            'movement_asset_result_id' => \App\Models\MovementAssetResult::factory(),
        ];
    }
}

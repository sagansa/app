<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\OnlineShopProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineShopProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnlineShopProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique->text(20),
        ];
    }
}

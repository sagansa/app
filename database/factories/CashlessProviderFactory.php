<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\CashlessProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashlessProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CashlessProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique->text(50),
        ];
    }
}

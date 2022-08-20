<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TransferStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferStockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransferStock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'from_store_id' => \App\Models\Store::factory(),
            'to_store_id' => \App\Models\Store::factory(),
            'approved_by_id' => \App\Models\User::factory(),
            'received_by_id' => \App\Models\User::factory(),
            'sent_by_id' => \App\Models\User::factory(),
        ];
    }
}

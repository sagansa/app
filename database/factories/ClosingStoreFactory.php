<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ClosingStore;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClosingStoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClosingStore::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'cash_from_yesterday' => $this->faker->randomNumber,
            'cash_for_tomorrow' => $this->faker->randomNumber,
            'total_cash_transfer' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => \App\Models\Store::factory(),
            'shift_store_id' => \App\Models\ShiftStore::factory(),
            'transfer_by_id' => \App\Models\User::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}

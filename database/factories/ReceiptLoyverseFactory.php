<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ReceiptLoyverse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptLoyverseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReceiptLoyverse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'receipt_number' => $this->faker->unique->text(255),
            'receipt_type' => $this->faker->text(255),
            'gross_sales' => $this->faker->text(255),
            'discounts' => $this->faker->text(255),
            'net_sales' => $this->faker->text(255),
            'taxes' => $this->faker->text(255),
            'total_collected' => $this->faker->text(255),
            'cost_of_goods' => $this->faker->text(255),
            'gross_profit' => $this->faker->text(255),
            'payment_type' => $this->faker->text(255),
            'description' => $this->faker->text,
            'dining_option' => $this->faker->text(255),
            'pos' => $this->faker->text(255),
            'store' => $this->faker->text(255),
            'cashier_name' => $this->faker->text(255),
            'customer_name' => $this->faker->text(255),
            'customer_contacts' => $this->faker->text(255),
            'status' => $this->faker->word,
        ];
    }
}

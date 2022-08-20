<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ReceiptByItemLoyverse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptByItemLoyverseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReceiptByItemLoyverse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'receipt_number' => $this->faker->text(255),
            'receipt_type' => $this->faker->text(255),
            'category' => $this->faker->text(255),
            'sku' => $this->faker->text(255),
            'item' => $this->faker->text(255),
            'variant' => $this->faker->text(255),
            'modifiers_applied' => $this->faker->text(255),
            'quantity' => $this->faker->randomNumber,
            'gross_sales' => $this->faker->text(255),
            'discounts' => $this->faker->text(255),
            'net_sales' => $this->faker->text(255),
            'cost_of_goods' => $this->faker->text(255),
            'gross_profit' => $this->faker->text(255),
            'taxes' => $this->faker->text(255),
            'dining_option' => $this->faker->text(255),
            'pos' => $this->faker->text(255),
            'store' => $this->faker->text(255),
            'cashier_name' => $this->faker->text(255),
            'customer_name' => $this->faker->text(255),
            'customer_contacts' => $this->faker->text(255),
            'comment' => $this->faker->text(255),
            'status' => $this->faker->word,
        ];
    }
}

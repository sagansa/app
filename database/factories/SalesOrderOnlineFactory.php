<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SalesOrderOnline;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderOnlineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderOnline::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'receipt_no' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'image_sent' => $this->faker->text(255),
            'store_id' => \App\Models\Store::factory(),
            'online_shop_provider_id' => \App\Models\OnlineShopProvider::factory(),
            'customer_id' => \App\Models\Customer::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
            'delivery_service_id' => \App\Models\DeliveryService::factory(),
            'delivery_address_id' => \App\Models\DeliveryAddress::factory(),
        ];
    }
}

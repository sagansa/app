<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->text(50),
            'sku' => $this->faker->text(255),
            'barcode' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'request' => $this->faker->numberBetween(1, 2),
            'remaining' => $this->faker->numberBetween(1, 2),
            'user_id' => \App\Models\User::factory(),
            'unit_id' => \App\Models\Unit::factory(),
            'material_group_id' => \App\Models\MaterialGroup::factory(),
            'franchise_group_id' => \App\Models\FranchiseGroup::factory(),
            'payment_type_id' => \App\Models\PaymentType::factory(),
            'online_category_id' => \App\Models\OnlineCategory::factory(),
            'product_group_id' => \App\Models\ProductGroup::factory(),
            'restaurant_category_id' => \App\Models\RestaurantCategory::factory(),
        ];
    }
}

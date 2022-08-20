<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;

use App\Models\Unit;
use App\Models\PaymentType;
use App\Models\ProductGroup;
use App\Models\MaterialGroup;
use App\Models\FranchiseGroup;
use App\Models\OnlineCategory;
use App\Models\RestaurantCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_products_list()
    {
        $products = Product::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product()
    {
        $data = Product::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.products.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_product()
    {
        $product = Product::factory()->create();

        $user = User::factory()->create();
        $unit = Unit::factory()->create();
        $materialGroup = MaterialGroup::factory()->create();
        $franchiseGroup = FranchiseGroup::factory()->create();
        $paymentType = PaymentType::factory()->create();
        $onlineCategory = OnlineCategory::factory()->create();
        $productGroup = ProductGroup::factory()->create();
        $restaurantCategory = RestaurantCategory::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'slug' => $this->faker->text(50),
            'sku' => $this->faker->text(255),
            'barcode' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'request' => $this->faker->numberBetween(1, 2),
            'remaining' => $this->faker->numberBetween(1, 2),
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'material_group_id' => $materialGroup->id,
            'franchise_group_id' => $franchiseGroup->id,
            'payment_type_id' => $paymentType->id,
            'online_category_id' => $onlineCategory->id,
            'product_group_id' => $productGroup->id,
            'restaurant_category_id' => $restaurantCategory->id,
        ];

        $response = $this->putJson(
            route('api.products.update', $product),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $product->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.products.destroy', $product));

        $this->assertSoftDeleted($product);

        $response->assertNoContent();
    }
}

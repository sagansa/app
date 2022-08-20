<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\RestaurantCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestaurantCategoryProductsTest extends TestCase
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
    public function it_gets_restaurant_category_products()
    {
        $restaurantCategory = RestaurantCategory::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'restaurant_category_id' => $restaurantCategory->id,
            ]);

        $response = $this->getJson(
            route(
                'api.restaurant-categories.products.index',
                $restaurantCategory
            )
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_restaurant_category_products()
    {
        $restaurantCategory = RestaurantCategory::factory()->create();
        $data = Product::factory()
            ->make([
                'restaurant_category_id' => $restaurantCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.restaurant-categories.products.store',
                $restaurantCategory
            ),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals(
            $restaurantCategory->id,
            $product->restaurant_category_id
        );
    }
}

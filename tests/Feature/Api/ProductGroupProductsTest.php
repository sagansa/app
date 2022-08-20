<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductGroupProductsTest extends TestCase
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
    public function it_gets_product_group_products()
    {
        $productGroup = ProductGroup::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'product_group_id' => $productGroup->id,
            ]);

        $response = $this->getJson(
            route('api.product-groups.products.index', $productGroup)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_group_products()
    {
        $productGroup = ProductGroup::factory()->create();
        $data = Product::factory()
            ->make([
                'product_group_id' => $productGroup->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.product-groups.products.store', $productGroup),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($productGroup->id, $product->product_group_id);
    }
}

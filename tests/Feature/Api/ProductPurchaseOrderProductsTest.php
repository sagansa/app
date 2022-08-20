<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\PurchaseOrderProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPurchaseOrderProductsTest extends TestCase
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
    public function it_gets_product_purchase_order_products()
    {
        $product = Product::factory()->create();
        $purchaseOrderProducts = PurchaseOrderProduct::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.purchase-order-products.index', $product)
        );

        $response
            ->assertOk()
            ->assertSee($purchaseOrderProducts[0]->quantity_invoice);
    }

    /**
     * @test
     */
    public function it_stores_the_product_purchase_order_products()
    {
        $product = Product::factory()->create();
        $data = PurchaseOrderProduct::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.purchase-order-products.store', $product),
            $data
        );

        unset($data['purchase_order_id']);

        $this->assertDatabaseHas('purchase_order_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseOrderProduct = PurchaseOrderProduct::latest('id')->first();

        $this->assertEquals($product->id, $purchaseOrderProduct->product_id);
    }
}

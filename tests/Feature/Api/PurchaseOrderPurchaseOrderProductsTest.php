<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseOrderPurchaseOrderProductsTest extends TestCase
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
    public function it_gets_purchase_order_purchase_order_products()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $purchaseOrderProducts = PurchaseOrderProduct::factory()
            ->count(2)
            ->create([
                'purchase_order_id' => $purchaseOrder->id,
            ]);

        $response = $this->getJson(
            route(
                'api.purchase-orders.purchase-order-products.index',
                $purchaseOrder
            )
        );

        $response
            ->assertOk()
            ->assertSee($purchaseOrderProducts[0]->quantity_invoice);
    }

    /**
     * @test
     */
    public function it_stores_the_purchase_order_purchase_order_products()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $data = PurchaseOrderProduct::factory()
            ->make([
                'purchase_order_id' => $purchaseOrder->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.purchase-orders.purchase-order-products.store',
                $purchaseOrder
            ),
            $data
        );

        unset($data['purchase_order_id']);

        $this->assertDatabaseHas('purchase_order_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseOrderProduct = PurchaseOrderProduct::latest('id')->first();

        $this->assertEquals(
            $purchaseOrder->id,
            $purchaseOrderProduct->purchase_order_id
        );
    }
}

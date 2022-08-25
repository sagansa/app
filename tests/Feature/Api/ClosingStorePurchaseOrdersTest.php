<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;
use App\Models\PurchaseOrder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStorePurchaseOrdersTest extends TestCase
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
    public function it_gets_closing_store_purchase_orders()
    {
        $closingStore = ClosingStore::factory()->create();
        $purchaseOrder = PurchaseOrder::factory()->create();

        $closingStore->purchaseOrders()->attach($purchaseOrder);

        $response = $this->getJson(
            route('api.closing-stores.purchase-orders.index', $closingStore)
        );

        $response->assertOk()->assertSee($purchaseOrder->image);
    }

    /**
     * @test
     */
    public function it_can_attach_purchase_orders_to_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->postJson(
            route('api.closing-stores.purchase-orders.store', [
                $closingStore,
                $purchaseOrder,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $closingStore
                ->purchaseOrders()
                ->where('purchase_orders.id', $purchaseOrder->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_purchase_orders_from_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-stores.purchase-orders.store', [
                $closingStore,
                $purchaseOrder,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $closingStore
                ->purchaseOrders()
                ->where('purchase_orders.id', $purchaseOrder->id)
                ->exists()
        );
    }
}

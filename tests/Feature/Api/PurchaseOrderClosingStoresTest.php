<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;
use App\Models\PurchaseOrder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseOrderClosingStoresTest extends TestCase
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
    public function it_gets_purchase_order_closing_stores()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $purchaseOrder->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route('api.purchase-orders.closing-stores.index', $purchaseOrder)
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.purchase-orders.closing-stores.store', [
                $purchaseOrder,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $purchaseOrder
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.purchase-orders.closing-stores.store', [
                $purchaseOrder,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $purchaseOrder
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}

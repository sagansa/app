<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseReceiptPurchaseOrdersTest extends TestCase
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
    public function it_gets_purchase_receipt_purchase_orders()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();
        $purchaseOrder = PurchaseOrder::factory()->create();

        $purchaseReceipt->purchaseOrders()->attach($purchaseOrder);

        $response = $this->getJson(
            route(
                'api.purchase-receipts.purchase-orders.index',
                $purchaseReceipt
            )
        );

        $response->assertOk()->assertSee($purchaseOrder->image);
    }

    /**
     * @test
     */
    public function it_can_attach_purchase_orders_to_purchase_receipt()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->postJson(
            route('api.purchase-receipts.purchase-orders.store', [
                $purchaseReceipt,
                $purchaseOrder,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $purchaseReceipt
                ->purchaseOrders()
                ->where('purchase_orders.id', $purchaseOrder->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_purchase_orders_from_purchase_receipt()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->deleteJson(
            route('api.purchase-receipts.purchase-orders.store', [
                $purchaseReceipt,
                $purchaseOrder,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $purchaseReceipt
                ->purchaseOrders()
                ->where('purchase_orders.id', $purchaseOrder->id)
                ->exists()
        );
    }
}

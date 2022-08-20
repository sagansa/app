<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseOrderPurchaseReceiptsTest extends TestCase
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
    public function it_gets_purchase_order_purchase_receipts()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $purchaseOrder->purchaseReceipts()->attach($purchaseReceipt);

        $response = $this->getJson(
            route('api.purchase-orders.purchase-receipts.index', $purchaseOrder)
        );

        $response->assertOk()->assertSee($purchaseReceipt->image);
    }

    /**
     * @test
     */
    public function it_can_attach_purchase_receipts_to_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $response = $this->postJson(
            route('api.purchase-orders.purchase-receipts.store', [
                $purchaseOrder,
                $purchaseReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $purchaseOrder
                ->purchaseReceipts()
                ->where('purchase_receipts.id', $purchaseReceipt->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_purchase_receipts_from_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $response = $this->deleteJson(
            route('api.purchase-orders.purchase-receipts.store', [
                $purchaseOrder,
                $purchaseReceipt,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $purchaseOrder
                ->purchaseReceipts()
                ->where('purchase_receipts.id', $purchaseReceipt->id)
                ->exists()
        );
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Supplier;
use App\Models\PurchaseOrder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierPurchaseOrdersTest extends TestCase
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
    public function it_gets_supplier_purchase_orders()
    {
        $supplier = Supplier::factory()->create();
        $purchaseOrders = PurchaseOrder::factory()
            ->count(2)
            ->create([
                'supplier_id' => $supplier->id,
            ]);

        $response = $this->getJson(
            route('api.suppliers.purchase-orders.index', $supplier)
        );

        $response->assertOk()->assertSee($purchaseOrders[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_supplier_purchase_orders()
    {
        $supplier = Supplier::factory()->create();
        $data = PurchaseOrder::factory()
            ->make([
                'supplier_id' => $supplier->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.suppliers.purchase-orders.store', $supplier),
            $data
        );

        $this->assertDatabaseHas('purchase_orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseOrder = PurchaseOrder::latest('id')->first();

        $this->assertEquals($supplier->id, $purchaseOrder->supplier_id);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\PurchaseOrder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorePurchaseOrdersTest extends TestCase
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
    public function it_gets_store_purchase_orders()
    {
        $store = Store::factory()->create();
        $purchaseOrders = PurchaseOrder::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.purchase-orders.index', $store)
        );

        $response->assertOk()->assertSee($purchaseOrders[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_purchase_orders()
    {
        $store = Store::factory()->create();
        $data = PurchaseOrder::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.purchase-orders.store', $store),
            $data
        );

        $this->assertDatabaseHas('purchase_orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseOrder = PurchaseOrder::latest('id')->first();

        $this->assertEquals($store->id, $purchaseOrder->store_id);
    }
}

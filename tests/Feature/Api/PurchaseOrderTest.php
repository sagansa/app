<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseOrder;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\PaymentType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseOrderTest extends TestCase
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
    public function it_gets_purchase_orders_list()
    {
        $purchaseOrders = PurchaseOrder::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.purchase-orders.index'));

        $response->assertOk()->assertSee($purchaseOrders[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_purchase_order()
    {
        $data = PurchaseOrder::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.purchase-orders.store'), $data);

        $this->assertDatabaseHas('purchase_orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();

        $paymentType = PaymentType::factory()->create();
        $store = Store::factory()->create();
        $supplier = Supplier::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'taxes' => $this->faker->randomNumber,
            'discounts' => $this->faker->randomNumber,
            'notes' => $this->faker->text,
            'payment_status' => $this->faker->numberBetween(1, 3),
            'order_status' => $this->faker->numberBetween(1, 3),
            'payment_type_id' => $paymentType->id,
            'store_id' => $store->id,
            'supplier_id' => $supplier->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.purchase-orders.update', $purchaseOrder),
            $data
        );

        $data['id'] = $purchaseOrder->id;

        $this->assertDatabaseHas('purchase_orders', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->deleteJson(
            route('api.purchase-orders.destroy', $purchaseOrder)
        );

        $this->assertModelMissing($purchaseOrder);

        $response->assertNoContent();
    }
}

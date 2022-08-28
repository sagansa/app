<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PurchaseOrder;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\PaymentType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseOrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_purchase_orders()
    {
        $purchaseOrders = PurchaseOrder::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('purchase-orders.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.purchase_orders.index')
            ->assertViewHas('purchaseOrders');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_purchase_order()
    {
        $response = $this->get(route('purchase-orders.create'));

        $response->assertOk()->assertViewIs('app.purchase_orders.create');
    }

    /**
     * @test
     */
    public function it_stores_the_purchase_order()
    {
        $data = PurchaseOrder::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('purchase-orders.store'), $data);

        $this->assertDatabaseHas('purchase_orders', $data);

        $purchaseOrder = PurchaseOrder::latest('id')->first();

        $response->assertRedirect(
            route('purchase-orders.edit', $purchaseOrder)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->get(route('purchase-orders.show', $purchaseOrder));

        $response
            ->assertOk()
            ->assertViewIs('app.purchase_orders.show')
            ->assertViewHas('purchaseOrder');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->get(route('purchase-orders.edit', $purchaseOrder));

        $response
            ->assertOk()
            ->assertViewIs('app.purchase_orders.edit')
            ->assertViewHas('purchaseOrder');
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

        $response = $this->put(
            route('purchase-orders.update', $purchaseOrder),
            $data
        );

        $data['id'] = $purchaseOrder->id;

        $this->assertDatabaseHas('purchase_orders', $data);

        $response->assertRedirect(
            route('purchase-orders.edit', $purchaseOrder)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_purchase_order()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();

        $response = $this->delete(
            route('purchase-orders.destroy', $purchaseOrder)
        );

        $response->assertRedirect(route('purchase-orders.index'));

        $this->assertModelMissing($purchaseOrder);
    }
}

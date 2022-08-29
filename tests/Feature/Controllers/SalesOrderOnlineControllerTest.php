<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SalesOrderOnline;

use App\Models\Store;
use App\Models\Customer;
use App\Models\DeliveryService;
use App\Models\DeliveryAddress;
use App\Models\OnlineShopProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderOnlineControllerTest extends TestCase
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
    public function it_displays_index_view_with_sales_order_onlines()
    {
        $salesOrderOnlines = SalesOrderOnline::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sales-order-onlines.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_onlines.index')
            ->assertViewHas('salesOrderOnlines');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sales_order_online()
    {
        $response = $this->get(route('sales-order-onlines.create'));

        $response->assertOk()->assertViewIs('app.sales_order_onlines.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_online()
    {
        $data = SalesOrderOnline::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sales-order-onlines.store'), $data);

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $salesOrderOnline = SalesOrderOnline::latest('id')->first();

        $response->assertRedirect(
            route('sales-order-onlines.edit', $salesOrderOnline)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sales_order_online()
    {
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $response = $this->get(
            route('sales-order-onlines.show', $salesOrderOnline)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_onlines.show')
            ->assertViewHas('salesOrderOnline');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sales_order_online()
    {
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $response = $this->get(
            route('sales-order-onlines.edit', $salesOrderOnline)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sales_order_onlines.edit')
            ->assertViewHas('salesOrderOnline');
    }

    /**
     * @test
     */
    public function it_updates_the_sales_order_online()
    {
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $store = Store::factory()->create();
        $onlineShopProvider = OnlineShopProvider::factory()->create();
        $customer = Customer::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();
        $deliveryService = DeliveryService::factory()->create();
        $deliveryAddress = DeliveryAddress::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'receipt_no' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'image_sent' => $this->faker->text(255),
            'store_id' => $store->id,
            'online_shop_provider_id' => $onlineShopProvider->id,
            'customer_id' => $customer->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
            'delivery_service_id' => $deliveryService->id,
            'delivery_address_id' => $deliveryAddress->id,
        ];

        $response = $this->put(
            route('sales-order-onlines.update', $salesOrderOnline),
            $data
        );

        $data['id'] = $salesOrderOnline->id;

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertRedirect(
            route('sales-order-onlines.edit', $salesOrderOnline)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_sales_order_online()
    {
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $response = $this->delete(
            route('sales-order-onlines.destroy', $salesOrderOnline)
        );

        $response->assertRedirect(route('sales-order-onlines.index'));

        $this->assertModelMissing($salesOrderOnline);
    }
}

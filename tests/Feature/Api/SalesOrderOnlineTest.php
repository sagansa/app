<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderOnline;

use App\Models\Store;
use App\Models\Customer;
use App\Models\DeliveryService;
use App\Models\DeliveryAddress;
use App\Models\OnlineShopProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesOrderOnlineTest extends TestCase
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
    public function it_gets_sales_order_onlines_list()
    {
        $salesOrderOnlines = SalesOrderOnline::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sales-order-onlines.index'));

        $response->assertOk()->assertSee($salesOrderOnlines[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_sales_order_online()
    {
        $data = SalesOrderOnline::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.sales-order-onlines.store'),
            $data
        );

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.sales-order-onlines.update', $salesOrderOnline),
            $data
        );

        $data['id'] = $salesOrderOnline->id;

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sales_order_online()
    {
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $response = $this->deleteJson(
            route('api.sales-order-onlines.destroy', $salesOrderOnline)
        );

        $this->assertModelMissing($salesOrderOnline);

        $response->assertNoContent();
    }
}

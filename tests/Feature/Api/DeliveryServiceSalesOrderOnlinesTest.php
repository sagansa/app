<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeliveryService;
use App\Models\SalesOrderOnline;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryServiceSalesOrderOnlinesTest extends TestCase
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
    public function it_gets_delivery_service_sales_order_onlines()
    {
        $deliveryService = DeliveryService::factory()->create();
        $salesOrderOnlines = SalesOrderOnline::factory()
            ->count(2)
            ->create([
                'delivery_service_id' => $deliveryService->id,
            ]);

        $response = $this->getJson(
            route(
                'api.delivery-services.sales-order-onlines.index',
                $deliveryService
            )
        );

        $response->assertOk()->assertSee($salesOrderOnlines[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_service_sales_order_onlines()
    {
        $deliveryService = DeliveryService::factory()->create();
        $data = SalesOrderOnline::factory()
            ->make([
                'delivery_service_id' => $deliveryService->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.delivery-services.sales-order-onlines.store',
                $deliveryService
            ),
            $data
        );

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderOnline = SalesOrderOnline::latest('id')->first();

        $this->assertEquals(
            $deliveryService->id,
            $salesOrderOnline->delivery_service_id
        );
    }
}

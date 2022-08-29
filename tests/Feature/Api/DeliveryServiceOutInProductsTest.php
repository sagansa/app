<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\OutInProduct;
use App\Models\DeliveryService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryServiceOutInProductsTest extends TestCase
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
    public function it_gets_delivery_service_out_in_products()
    {
        $deliveryService = DeliveryService::factory()->create();
        $outInProducts = OutInProduct::factory()
            ->count(2)
            ->create([
                'delivery_service_id' => $deliveryService->id,
            ]);

        $response = $this->getJson(
            route(
                'api.delivery-services.out-in-products.index',
                $deliveryService
            )
        );

        $response->assertOk()->assertSee($outInProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_service_out_in_products()
    {
        $deliveryService = DeliveryService::factory()->create();
        $data = OutInProduct::factory()
            ->make([
                'delivery_service_id' => $deliveryService->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.delivery-services.out-in-products.store',
                $deliveryService
            ),
            $data
        );

        unset($data['delivery_service_id']);

        $this->assertDatabaseHas('out_in_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $outInProduct = OutInProduct::latest('id')->first();

        $this->assertEquals(
            $deliveryService->id,
            $outInProduct->delivery_service_id
        );
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeliveryService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryServiceTest extends TestCase
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
    public function it_gets_delivery_services_list()
    {
        $deliveryServices = DeliveryService::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.delivery-services.index'));

        $response->assertOk()->assertSee($deliveryServices[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_service()
    {
        $data = DeliveryService::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.delivery-services.store'),
            $data
        );

        $this->assertDatabaseHas('delivery_services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_delivery_service()
    {
        $deliveryService = DeliveryService::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'status' => $this->faker->numberBetween(1, 2),
        ];

        $response = $this->putJson(
            route('api.delivery-services.update', $deliveryService),
            $data
        );

        $data['id'] = $deliveryService->id;

        $this->assertDatabaseHas('delivery_services', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_delivery_service()
    {
        $deliveryService = DeliveryService::factory()->create();

        $response = $this->deleteJson(
            route('api.delivery-services.destroy', $deliveryService)
        );

        $this->assertModelMissing($deliveryService);

        $response->assertNoContent();
    }
}

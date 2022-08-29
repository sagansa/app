<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DeliveryService;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryServiceControllerTest extends TestCase
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
    public function it_displays_index_view_with_delivery_services()
    {
        $deliveryServices = DeliveryService::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('delivery-services.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.delivery_services.index')
            ->assertViewHas('deliveryServices');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_delivery_service()
    {
        $response = $this->get(route('delivery-services.create'));

        $response->assertOk()->assertViewIs('app.delivery_services.create');
    }

    /**
     * @test
     */
    public function it_stores_the_delivery_service()
    {
        $data = DeliveryService::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('delivery-services.store'), $data);

        $this->assertDatabaseHas('delivery_services', $data);

        $deliveryService = DeliveryService::latest('id')->first();

        $response->assertRedirect(
            route('delivery-services.edit', $deliveryService)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_delivery_service()
    {
        $deliveryService = DeliveryService::factory()->create();

        $response = $this->get(
            route('delivery-services.show', $deliveryService)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.delivery_services.show')
            ->assertViewHas('deliveryService');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_delivery_service()
    {
        $deliveryService = DeliveryService::factory()->create();

        $response = $this->get(
            route('delivery-services.edit', $deliveryService)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.delivery_services.edit')
            ->assertViewHas('deliveryService');
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

        $response = $this->put(
            route('delivery-services.update', $deliveryService),
            $data
        );

        $data['id'] = $deliveryService->id;

        $this->assertDatabaseHas('delivery_services', $data);

        $response->assertRedirect(
            route('delivery-services.edit', $deliveryService)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_delivery_service()
    {
        $deliveryService = DeliveryService::factory()->create();

        $response = $this->delete(
            route('delivery-services.destroy', $deliveryService)
        );

        $response->assertRedirect(route('delivery-services.index'));

        $this->assertModelMissing($deliveryService);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleClosingStoresTest extends TestCase
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
    public function it_gets_vehicle_closing_stores()
    {
        $vehicle = Vehicle::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $vehicle->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route('api.vehicles.closing-stores.index', $vehicle)
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_vehicle()
    {
        $vehicle = Vehicle::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.vehicles.closing-stores.store', [
                $vehicle,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $vehicle
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_vehicle()
    {
        $vehicle = Vehicle::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.vehicles.closing-stores.store', [
                $vehicle,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $vehicle
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\FuelService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleFuelServicesTest extends TestCase
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
    public function it_gets_vehicle_fuel_services()
    {
        $vehicle = Vehicle::factory()->create();
        $fuelServices = FuelService::factory()
            ->count(2)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route('api.vehicles.fuel-services.index', $vehicle)
        );

        $response->assertOk()->assertSee($fuelServices[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_fuel_services()
    {
        $vehicle = Vehicle::factory()->create();
        $data = FuelService::factory()
            ->make([
                'vehicle_id' => $vehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vehicles.fuel-services.store', $vehicle),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);
        unset($data['notes']);

        $this->assertDatabaseHas('fuel_services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fuelService = FuelService::latest('id')->first();

        $this->assertEquals($vehicle->id, $fuelService->vehicle_id);
    }
}

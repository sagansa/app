<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleTax;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleVehicleTaxesTest extends TestCase
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
    public function it_gets_vehicle_vehicle_taxes()
    {
        $vehicle = Vehicle::factory()->create();
        $vehicleTaxes = VehicleTax::factory()
            ->count(2)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route('api.vehicles.vehicle-taxes.index', $vehicle)
        );

        $response->assertOk()->assertSee($vehicleTaxes[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_vehicle_taxes()
    {
        $vehicle = Vehicle::factory()->create();
        $data = VehicleTax::factory()
            ->make([
                'vehicle_id' => $vehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vehicles.vehicle-taxes.store', $vehicle),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('vehicle_taxes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicleTax = VehicleTax::latest('id')->first();

        $this->assertEquals($vehicle->id, $vehicleTax->vehicle_id);
    }
}

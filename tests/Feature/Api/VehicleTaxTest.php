<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\VehicleTax;

use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleTaxTest extends TestCase
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
    public function it_gets_vehicle_taxes_list()
    {
        $vehicleTaxes = VehicleTax::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.vehicle-taxes.index'));

        $response->assertOk()->assertSee($vehicleTaxes[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_tax()
    {
        $data = VehicleTax::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.vehicle-taxes.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('vehicle_taxes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_vehicle_tax()
    {
        $vehicleTax = VehicleTax::factory()->create();

        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();

        $data = [
            'amount_tax' => $this->faker->randomNumber,
            'expired_date' => $this->faker->date,
            'notes' => $this->faker->text,
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.vehicle-taxes.update', $vehicleTax),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $vehicleTax->id;

        $this->assertDatabaseHas('vehicle_taxes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle_tax()
    {
        $vehicleTax = VehicleTax::factory()->create();

        $response = $this->deleteJson(
            route('api.vehicle-taxes.destroy', $vehicleTax)
        );

        $this->assertModelMissing($vehicleTax);

        $response->assertNoContent();
    }
}

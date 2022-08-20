<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\VehicleCertificate;

use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleCertificateTest extends TestCase
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
    public function it_gets_vehicle_certificates_list()
    {
        $vehicleCertificates = VehicleCertificate::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.vehicle-certificates.index'));

        $response->assertOk()->assertSee($vehicleCertificates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_certificate()
    {
        $data = VehicleCertificate::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.vehicle-certificates.store'),
            $data
        );

        $this->assertDatabaseHas('vehicle_certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_vehicle_certificate()
    {
        $vehicleCertificate = VehicleCertificate::factory()->create();

        $vehicle = Vehicle::factory()->create();

        $data = [
            'BPKB' => $this->faker->numberBetween(1, 3),
            'STNK' => $this->faker->numberBetween(1, 3),
            'name' => $this->faker->name,
            'brand' => $this->faker->name,
            'type' => $this->faker->word,
            'category' => $this->faker->text(255),
            'model' => $this->faker->text(255),
            'manufacture_year' => $this->faker->year,
            'cylinder_capacity' => $this->faker->text(255),
            'vehilce_identity_no' => $this->faker->text(255),
            'engine_no' => $this->faker->text(255),
            'color' => $this->faker->hexcolor,
            'type_fuel' => $this->faker->text(255),
            'lisence_plate_color' => $this->faker->text(255),
            'registration_year' => $this->faker->text(255),
            'bpkb_no' => $this->faker->text(255),
            'location_code' => $this->faker->text(255),
            'registration_queue_no' => $this->faker->text(255),
            'notes' => $this->faker->text,
            'vehicle_id' => $vehicle->id,
        ];

        $response = $this->putJson(
            route('api.vehicle-certificates.update', $vehicleCertificate),
            $data
        );

        $data['id'] = $vehicleCertificate->id;

        $this->assertDatabaseHas('vehicle_certificates', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle_certificate()
    {
        $vehicleCertificate = VehicleCertificate::factory()->create();

        $response = $this->deleteJson(
            route('api.vehicle-certificates.destroy', $vehicleCertificate)
        );

        $this->assertModelMissing($vehicleCertificate);

        $response->assertNoContent();
    }
}

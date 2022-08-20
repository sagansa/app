<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\VehicleCertificate;

use App\Models\Vehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleCertificateControllerTest extends TestCase
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
    public function it_displays_index_view_with_vehicle_certificates()
    {
        $vehicleCertificates = VehicleCertificate::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('vehicle-certificates.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicle_certificates.index')
            ->assertViewHas('vehicleCertificates');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_vehicle_certificate()
    {
        $response = $this->get(route('vehicle-certificates.create'));

        $response->assertOk()->assertViewIs('app.vehicle_certificates.create');
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_certificate()
    {
        $data = VehicleCertificate::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('vehicle-certificates.store'), $data);

        $this->assertDatabaseHas('vehicle_certificates', $data);

        $vehicleCertificate = VehicleCertificate::latest('id')->first();

        $response->assertRedirect(
            route('vehicle-certificates.edit', $vehicleCertificate)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_vehicle_certificate()
    {
        $vehicleCertificate = VehicleCertificate::factory()->create();

        $response = $this->get(
            route('vehicle-certificates.show', $vehicleCertificate)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.vehicle_certificates.show')
            ->assertViewHas('vehicleCertificate');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_vehicle_certificate()
    {
        $vehicleCertificate = VehicleCertificate::factory()->create();

        $response = $this->get(
            route('vehicle-certificates.edit', $vehicleCertificate)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.vehicle_certificates.edit')
            ->assertViewHas('vehicleCertificate');
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

        $response = $this->put(
            route('vehicle-certificates.update', $vehicleCertificate),
            $data
        );

        $data['id'] = $vehicleCertificate->id;

        $this->assertDatabaseHas('vehicle_certificates', $data);

        $response->assertRedirect(
            route('vehicle-certificates.edit', $vehicleCertificate)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle_certificate()
    {
        $vehicleCertificate = VehicleCertificate::factory()->create();

        $response = $this->delete(
            route('vehicle-certificates.destroy', $vehicleCertificate)
        );

        $response->assertRedirect(route('vehicle-certificates.index'));

        $this->assertModelMissing($vehicleCertificate);
    }
}

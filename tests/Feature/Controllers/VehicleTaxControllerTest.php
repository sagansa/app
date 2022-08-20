<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\VehicleTax;

use App\Models\Vehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleTaxControllerTest extends TestCase
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
    public function it_displays_index_view_with_vehicle_taxes()
    {
        $vehicleTaxes = VehicleTax::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('vehicle-taxes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicle_taxes.index')
            ->assertViewHas('vehicleTaxes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_vehicle_tax()
    {
        $response = $this->get(route('vehicle-taxes.create'));

        $response->assertOk()->assertViewIs('app.vehicle_taxes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_tax()
    {
        $data = VehicleTax::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('vehicle-taxes.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('vehicle_taxes', $data);

        $vehicleTax = VehicleTax::latest('id')->first();

        $response->assertRedirect(route('vehicle-taxes.edit', $vehicleTax));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_vehicle_tax()
    {
        $vehicleTax = VehicleTax::factory()->create();

        $response = $this->get(route('vehicle-taxes.show', $vehicleTax));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicle_taxes.show')
            ->assertViewHas('vehicleTax');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_vehicle_tax()
    {
        $vehicleTax = VehicleTax::factory()->create();

        $response = $this->get(route('vehicle-taxes.edit', $vehicleTax));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicle_taxes.edit')
            ->assertViewHas('vehicleTax');
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

        $response = $this->put(
            route('vehicle-taxes.update', $vehicleTax),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $vehicleTax->id;

        $this->assertDatabaseHas('vehicle_taxes', $data);

        $response->assertRedirect(route('vehicle-taxes.edit', $vehicleTax));
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle_tax()
    {
        $vehicleTax = VehicleTax::factory()->create();

        $response = $this->delete(route('vehicle-taxes.destroy', $vehicleTax));

        $response->assertRedirect(route('vehicle-taxes.index'));

        $this->assertModelMissing($vehicleTax);
    }
}

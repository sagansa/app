<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FuelService;

use App\Models\Vehicle;
use App\Models\PaymentType;
use App\Models\ClosingStore;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelServiceControllerTest extends TestCase
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
    public function it_displays_index_view_with_fuel_services()
    {
        $fuelServices = FuelService::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('fuel-services.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.fuel_services.index')
            ->assertViewHas('fuelServices');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_fuel_service()
    {
        $response = $this->get(route('fuel-services.create'));

        $response->assertOk()->assertViewIs('app.fuel_services.create');
    }

    /**
     * @test
     */
    public function it_stores_the_fuel_service()
    {
        $data = FuelService::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('fuel-services.store'), $data);

        unset($data['created_by_id']);
        unset($data['approved_by_id']);
        unset($data['notes']);

        $this->assertDatabaseHas('fuel_services', $data);

        $fuelService = FuelService::latest('id')->first();

        $response->assertRedirect(route('fuel-services.edit', $fuelService));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_fuel_service()
    {
        $fuelService = FuelService::factory()->create();

        $response = $this->get(route('fuel-services.show', $fuelService));

        $response
            ->assertOk()
            ->assertViewIs('app.fuel_services.show')
            ->assertViewHas('fuelService');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_fuel_service()
    {
        $fuelService = FuelService::factory()->create();

        $response = $this->get(route('fuel-services.edit', $fuelService));

        $response
            ->assertOk()
            ->assertViewIs('app.fuel_services.edit')
            ->assertViewHas('fuelService');
    }

    /**
     * @test
     */
    public function it_updates_the_fuel_service()
    {
        $fuelService = FuelService::factory()->create();

        $closingStore = ClosingStore::factory()->create();
        $vehicle = Vehicle::factory()->create();
        $paymentType = PaymentType::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'fuel_service' => $this->faker->numberBetween(0, 127),
            'km' => $this->faker->randomNumber(2),
            'liter' => $this->faker->randomNumber(2),
            'amount' => $this->faker->randomNumber,
            'notes' => $this->faker->text,
            'closing_store_id' => $closingStore->id,
            'vehicle_id' => $vehicle->id,
            'payment_type_id' => $paymentType->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->put(
            route('fuel-services.update', $fuelService),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);
        unset($data['notes']);

        $data['id'] = $fuelService->id;

        $this->assertDatabaseHas('fuel_services', $data);

        $response->assertRedirect(route('fuel-services.edit', $fuelService));
    }

    /**
     * @test
     */
    public function it_deletes_the_fuel_service()
    {
        $fuelService = FuelService::factory()->create();

        $response = $this->delete(route('fuel-services.destroy', $fuelService));

        $response->assertRedirect(route('fuel-services.index'));

        $this->assertModelMissing($fuelService);
    }
}

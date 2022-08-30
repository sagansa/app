<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;

use App\Models\Vehicle;
use App\Models\PaymentType;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelServiceTest extends TestCase
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
    public function it_gets_fuel_services_list()
    {
        $fuelServices = FuelService::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.fuel-services.index'));

        $response->assertOk()->assertSee($fuelServices[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_fuel_service()
    {
        $data = FuelService::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.fuel-services.store'), $data);

        unset($data['created_by_id']);
        unset($data['approved_by_id']);
        unset($data['notes']);

        $this->assertDatabaseHas('fuel_services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.fuel-services.update', $fuelService),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);
        unset($data['notes']);

        $data['id'] = $fuelService->id;

        $this->assertDatabaseHas('fuel_services', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_fuel_service()
    {
        $fuelService = FuelService::factory()->create();

        $response = $this->deleteJson(
            route('api.fuel-services.destroy', $fuelService)
        );

        $this->assertModelMissing($fuelService);

        $response->assertNoContent();
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;
use App\Models\TransferFuelService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferFuelServiceFuelServicesTest extends TestCase
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
    public function it_gets_transfer_fuel_service_fuel_services()
    {
        $transferFuelService = TransferFuelService::factory()->create();
        $fuelService = FuelService::factory()->create();

        $transferFuelService->fuelServices()->attach($fuelService);

        $response = $this->getJson(
            route(
                'api.transfer-fuel-services.fuel-services.index',
                $transferFuelService
            )
        );

        $response->assertOk()->assertSee($fuelService->image);
    }

    /**
     * @test
     */
    public function it_can_attach_fuel_services_to_transfer_fuel_service()
    {
        $transferFuelService = TransferFuelService::factory()->create();
        $fuelService = FuelService::factory()->create();

        $response = $this->postJson(
            route('api.transfer-fuel-services.fuel-services.store', [
                $transferFuelService,
                $fuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $transferFuelService
                ->fuelServices()
                ->where('fuel_services.id', $fuelService->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_fuel_services_from_transfer_fuel_service()
    {
        $transferFuelService = TransferFuelService::factory()->create();
        $fuelService = FuelService::factory()->create();

        $response = $this->deleteJson(
            route('api.transfer-fuel-services.fuel-services.store', [
                $transferFuelService,
                $fuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $transferFuelService
                ->fuelServices()
                ->where('fuel_services.id', $fuelService->id)
                ->exists()
        );
    }
}

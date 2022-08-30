<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;
use App\Models\TransferFuelService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelServiceTransferFuelServicesTest extends TestCase
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
    public function it_gets_fuel_service_transfer_fuel_services()
    {
        $fuelService = FuelService::factory()->create();
        $transferFuelService = TransferFuelService::factory()->create();

        $fuelService->transferFuelServices()->attach($transferFuelService);

        $response = $this->getJson(
            route(
                'api.fuel-services.transfer-fuel-services.index',
                $fuelService
            )
        );

        $response->assertOk()->assertSee($transferFuelService->image);
    }

    /**
     * @test
     */
    public function it_can_attach_transfer_fuel_services_to_fuel_service()
    {
        $fuelService = FuelService::factory()->create();
        $transferFuelService = TransferFuelService::factory()->create();

        $response = $this->postJson(
            route('api.fuel-services.transfer-fuel-services.store', [
                $fuelService,
                $transferFuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $fuelService
                ->transferFuelServices()
                ->where('transfer_fuel_services.id', $transferFuelService->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_transfer_fuel_services_from_fuel_service()
    {
        $fuelService = FuelService::factory()->create();
        $transferFuelService = TransferFuelService::factory()->create();

        $response = $this->deleteJson(
            route('api.fuel-services.transfer-fuel-services.store', [
                $fuelService,
                $transferFuelService,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $fuelService
                ->transferFuelServices()
                ->where('transfer_fuel_services.id', $transferFuelService->id)
                ->exists()
        );
    }
}

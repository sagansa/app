<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TransferFuelService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferFuelServiceTest extends TestCase
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
    public function it_gets_transfer_fuel_services_list()
    {
        $transferFuelServices = TransferFuelService::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.transfer-fuel-services.index'));

        $response->assertOk()->assertSee($transferFuelServices[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_fuel_service()
    {
        $data = TransferFuelService::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.transfer-fuel-services.store'),
            $data
        );

        $this->assertDatabaseHas('transfer_fuel_services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_transfer_fuel_service()
    {
        $transferFuelService = TransferFuelService::factory()->create();

        $data = [
            'amount' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.transfer-fuel-services.update', $transferFuelService),
            $data
        );

        $data['id'] = $transferFuelService->id;

        $this->assertDatabaseHas('transfer_fuel_services', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_fuel_service()
    {
        $transferFuelService = TransferFuelService::factory()->create();

        $response = $this->deleteJson(
            route('api.transfer-fuel-services.destroy', $transferFuelService)
        );

        $this->assertModelMissing($transferFuelService);

        $response->assertNoContent();
    }
}

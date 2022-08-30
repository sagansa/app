<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\TransferFuelService;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferFuelServiceControllerTest extends TestCase
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
    public function it_displays_index_view_with_transfer_fuel_services()
    {
        $transferFuelServices = TransferFuelService::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('transfer-fuel-services.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_fuel_services.index')
            ->assertViewHas('transferFuelServices');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_transfer_fuel_service()
    {
        $response = $this->get(route('transfer-fuel-services.create'));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_fuel_services.create');
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_fuel_service()
    {
        $data = TransferFuelService::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('transfer-fuel-services.store'), $data);

        $this->assertDatabaseHas('transfer_fuel_services', $data);

        $transferFuelService = TransferFuelService::latest('id')->first();

        $response->assertRedirect(
            route('transfer-fuel-services.edit', $transferFuelService)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_transfer_fuel_service()
    {
        $transferFuelService = TransferFuelService::factory()->create();

        $response = $this->get(
            route('transfer-fuel-services.show', $transferFuelService)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_fuel_services.show')
            ->assertViewHas('transferFuelService');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_transfer_fuel_service()
    {
        $transferFuelService = TransferFuelService::factory()->create();

        $response = $this->get(
            route('transfer-fuel-services.edit', $transferFuelService)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_fuel_services.edit')
            ->assertViewHas('transferFuelService');
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

        $response = $this->put(
            route('transfer-fuel-services.update', $transferFuelService),
            $data
        );

        $data['id'] = $transferFuelService->id;

        $this->assertDatabaseHas('transfer_fuel_services', $data);

        $response->assertRedirect(
            route('transfer-fuel-services.edit', $transferFuelService)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_fuel_service()
    {
        $transferFuelService = TransferFuelService::factory()->create();

        $response = $this->delete(
            route('transfer-fuel-services.destroy', $transferFuelService)
        );

        $response->assertRedirect(route('transfer-fuel-services.index'));

        $this->assertModelMissing($transferFuelService);
    }
}

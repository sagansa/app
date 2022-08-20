<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreFuelServicesTest extends TestCase
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
    public function it_gets_closing_store_fuel_services()
    {
        $closingStore = ClosingStore::factory()->create();
        $fuelServices = FuelService::factory()
            ->count(2)
            ->create([
                'closing_store_id' => $closingStore->id,
            ]);

        $response = $this->getJson(
            route('api.closing-stores.fuel-services.index', $closingStore)
        );

        $response->assertOk()->assertSee($fuelServices[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_closing_store_fuel_services()
    {
        $closingStore = ClosingStore::factory()->create();
        $data = FuelService::factory()
            ->make([
                'closing_store_id' => $closingStore->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.closing-stores.fuel-services.store', $closingStore),
            $data
        );

        unset($data['closing_store_id']);

        $this->assertDatabaseHas('fuel_services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fuelService = FuelService::latest('id')->first();

        $this->assertEquals($closingStore->id, $fuelService->closing_store_id);
    }
}

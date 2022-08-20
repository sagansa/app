<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreVehiclesTest extends TestCase
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
    public function it_gets_store_vehicles()
    {
        $store = Store::factory()->create();
        $vehicles = Vehicle::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(route('api.stores.vehicles.index', $store));

        $response->assertOk()->assertSee($vehicles[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_vehicles()
    {
        $store = Store::factory()->create();
        $data = Vehicle::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.vehicles.store', $store),
            $data
        );

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicle = Vehicle::latest('id')->first();

        $this->assertEquals($store->id, $vehicle->store_id);
    }
}

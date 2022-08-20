<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\ContractLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreContractLocationsTest extends TestCase
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
    public function it_gets_store_contract_locations()
    {
        $store = Store::factory()->create();
        $contractLocations = ContractLocation::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.contract-locations.index', $store)
        );

        $response->assertOk()->assertSee($contractLocations[0]->file);
    }

    /**
     * @test
     */
    public function it_stores_the_store_contract_locations()
    {
        $store = Store::factory()->create();
        $data = ContractLocation::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.contract-locations.store', $store),
            $data
        );

        unset($data['store_id']);

        $this->assertDatabaseHas('contract_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $contractLocation = ContractLocation::latest('id')->first();

        $this->assertEquals($store->id, $contractLocation->store_id);
    }
}

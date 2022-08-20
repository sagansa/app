<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\MovementAssetResult;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreMovementAssetResultsTest extends TestCase
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
    public function it_gets_store_movement_asset_results()
    {
        $store = Store::factory()->create();
        $movementAssetResults = MovementAssetResult::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.movement-asset-results.index', $store)
        );

        $response->assertOk()->assertSee($movementAssetResults[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_movement_asset_results()
    {
        $store = Store::factory()->create();
        $data = MovementAssetResult::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.movement-asset-results.store', $store),
            $data
        );

        $this->assertDatabaseHas('movement_asset_results', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $movementAssetResult = MovementAssetResult::latest('id')->first();

        $this->assertEquals($store->id, $movementAssetResult->store_id);
    }
}

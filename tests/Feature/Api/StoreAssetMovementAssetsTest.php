<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StoreAsset;
use App\Models\MovementAsset;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAssetMovementAssetsTest extends TestCase
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
    public function it_gets_store_asset_movement_assets()
    {
        $storeAsset = StoreAsset::factory()->create();
        $movementAssets = MovementAsset::factory()
            ->count(2)
            ->create([
                'store_asset_id' => $storeAsset->id,
            ]);

        $response = $this->getJson(
            route('api.store-assets.movement-assets.index', $storeAsset)
        );

        $response->assertOk()->assertSee($movementAssets[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_asset_movement_assets()
    {
        $storeAsset = StoreAsset::factory()->create();
        $data = MovementAsset::factory()
            ->make([
                'store_asset_id' => $storeAsset->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.store-assets.movement-assets.store', $storeAsset),
            $data
        );

        unset($data['store_asset_id']);

        $this->assertDatabaseHas('movement_assets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $movementAsset = MovementAsset::latest('id')->first();

        $this->assertEquals($storeAsset->id, $movementAsset->store_asset_id);
    }
}

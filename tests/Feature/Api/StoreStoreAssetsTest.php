<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\StoreAsset;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreStoreAssetsTest extends TestCase
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
    public function it_gets_store_store_assets()
    {
        $store = Store::factory()->create();
        $storeAssets = StoreAsset::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.store-assets.index', $store)
        );

        $response->assertOk()->assertSee($storeAssets[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_store_store_assets()
    {
        $store = Store::factory()->create();
        $data = StoreAsset::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.store-assets.store', $store),
            $data
        );

        $this->assertDatabaseHas('store_assets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $storeAsset = StoreAsset::latest('id')->first();

        $this->assertEquals($store->id, $storeAsset->store_id);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StoreAsset;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAssetTest extends TestCase
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
    public function it_gets_store_assets_list()
    {
        $storeAssets = StoreAsset::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.store-assets.index'));

        $response->assertOk()->assertSee($storeAssets[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_store_asset()
    {
        $data = StoreAsset::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.store-assets.store'), $data);

        $this->assertDatabaseHas('store_assets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_store_asset()
    {
        $storeAsset = StoreAsset::factory()->create();

        $store = Store::factory()->create();

        $data = [
            'status' => $this->faker->numberBetween(1, 2),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
        ];

        $response = $this->putJson(
            route('api.store-assets.update', $storeAsset),
            $data
        );

        $data['id'] = $storeAsset->id;

        $this->assertDatabaseHas('store_assets', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_store_asset()
    {
        $storeAsset = StoreAsset::factory()->create();

        $response = $this->deleteJson(
            route('api.store-assets.destroy', $storeAsset)
        );

        $this->assertModelMissing($storeAsset);

        $response->assertNoContent();
    }
}

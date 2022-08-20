<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\StoreAsset;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAssetControllerTest extends TestCase
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
    public function it_displays_index_view_with_store_assets()
    {
        $storeAssets = StoreAsset::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('store-assets.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.store_assets.index')
            ->assertViewHas('storeAssets');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_store_asset()
    {
        $response = $this->get(route('store-assets.create'));

        $response->assertOk()->assertViewIs('app.store_assets.create');
    }

    /**
     * @test
     */
    public function it_stores_the_store_asset()
    {
        $data = StoreAsset::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('store-assets.store'), $data);

        $this->assertDatabaseHas('store_assets', $data);

        $storeAsset = StoreAsset::latest('id')->first();

        $response->assertRedirect(route('store-assets.edit', $storeAsset));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_store_asset()
    {
        $storeAsset = StoreAsset::factory()->create();

        $response = $this->get(route('store-assets.show', $storeAsset));

        $response
            ->assertOk()
            ->assertViewIs('app.store_assets.show')
            ->assertViewHas('storeAsset');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_store_asset()
    {
        $storeAsset = StoreAsset::factory()->create();

        $response = $this->get(route('store-assets.edit', $storeAsset));

        $response
            ->assertOk()
            ->assertViewIs('app.store_assets.edit')
            ->assertViewHas('storeAsset');
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

        $response = $this->put(
            route('store-assets.update', $storeAsset),
            $data
        );

        $data['id'] = $storeAsset->id;

        $this->assertDatabaseHas('store_assets', $data);

        $response->assertRedirect(route('store-assets.edit', $storeAsset));
    }

    /**
     * @test
     */
    public function it_deletes_the_store_asset()
    {
        $storeAsset = StoreAsset::factory()->create();

        $response = $this->delete(route('store-assets.destroy', $storeAsset));

        $response->assertRedirect(route('store-assets.index'));

        $this->assertModelMissing($storeAsset);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\MovementAsset;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductMovementAssetsTest extends TestCase
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
    public function it_gets_product_movement_assets()
    {
        $product = Product::factory()->create();
        $movementAssets = MovementAsset::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.movement-assets.index', $product)
        );

        $response->assertOk()->assertSee($movementAssets[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_product_movement_assets()
    {
        $product = Product::factory()->create();
        $data = MovementAsset::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.movement-assets.store', $product),
            $data
        );

        unset($data['store_asset_id']);

        $this->assertDatabaseHas('movement_assets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $movementAsset = MovementAsset::latest('id')->first();

        $this->assertEquals($product->id, $movementAsset->product_id);
    }
}

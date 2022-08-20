<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductionSupportFrom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductionSupportFromsTest extends TestCase
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
    public function it_gets_product_production_support_froms()
    {
        $product = Product::factory()->create();
        $productionSupportFroms = ProductionSupportFrom::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.production-support-froms.index', $product)
        );

        $response->assertOk()->assertSee($productionSupportFroms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_production_support_froms()
    {
        $product = Product::factory()->create();
        $data = ProductionSupportFrom::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.production-support-froms.store', $product),
            $data
        );

        unset($data['production_id']);

        $this->assertDatabaseHas('production_support_froms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productionSupportFrom = ProductionSupportFrom::latest('id')->first();

        $this->assertEquals($product->id, $productionSupportFrom->product_id);
    }
}

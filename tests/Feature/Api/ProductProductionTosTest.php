<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductionTo;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductionTosTest extends TestCase
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
    public function it_gets_product_production_tos()
    {
        $product = Product::factory()->create();
        $productionTos = ProductionTo::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.production-tos.index', $product)
        );

        $response->assertOk()->assertSee($productionTos[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_production_tos()
    {
        $product = Product::factory()->create();
        $data = ProductionTo::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.production-tos.store', $product),
            $data
        );

        unset($data['production_id']);

        $this->assertDatabaseHas('production_tos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productionTo = ProductionTo::latest('id')->first();

        $this->assertEquals($product->id, $productionTo->product_id);
    }
}

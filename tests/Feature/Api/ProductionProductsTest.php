<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionProductsTest extends TestCase
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
    public function it_gets_production_products()
    {
        $production = Production::factory()->create();
        $product = Product::factory()->create();

        $production->from_support_products()->attach($product);

        $response = $this->getJson(
            route('api.productions.products.index', $production)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_production()
    {
        $production = Production::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.productions.products.store', [$production, $product])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $production
                ->from_support_products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_production()
    {
        $production = Production::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.productions.products.store', [$production, $product])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $production
                ->from_support_products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

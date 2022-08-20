<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\RemainingStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemainingStockProductsTest extends TestCase
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
    public function it_gets_remaining_stock_products()
    {
        $remainingStock = RemainingStock::factory()->create();
        $product = Product::factory()->create();

        $remainingStock->products()->attach($product);

        $response = $this->getJson(
            route('api.remaining-stocks.products.index', $remainingStock)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_remaining_stock()
    {
        $remainingStock = RemainingStock::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.remaining-stocks.products.store', [
                $remainingStock,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $remainingStock
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_remaining_stock()
    {
        $remainingStock = RemainingStock::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.remaining-stocks.products.store', [
                $remainingStock,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $remainingStock
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

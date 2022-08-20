<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\RequestStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestStockProductsTest extends TestCase
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
    public function it_gets_request_stock_products()
    {
        $requestStock = RequestStock::factory()->create();
        $product = Product::factory()->create();

        $requestStock->products()->attach($product);

        $response = $this->getJson(
            route('api.request-stocks.products.index', $requestStock)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_request_stock()
    {
        $requestStock = RequestStock::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.request-stocks.products.store', [
                $requestStock,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $requestStock
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_request_stock()
    {
        $requestStock = RequestStock::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.request-stocks.products.store', [
                $requestStock,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $requestStock
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

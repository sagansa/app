<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\RequestStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRequestStocksTest extends TestCase
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
    public function it_gets_product_request_stocks()
    {
        $product = Product::factory()->create();
        $requestStock = RequestStock::factory()->create();

        $product->requestStocks()->attach($requestStock);

        $response = $this->getJson(
            route('api.products.request-stocks.index', $product)
        );

        $response->assertOk()->assertSee($requestStock->notes);
    }

    /**
     * @test
     */
    public function it_can_attach_request_stocks_to_product()
    {
        $product = Product::factory()->create();
        $requestStock = RequestStock::factory()->create();

        $response = $this->postJson(
            route('api.products.request-stocks.store', [
                $product,
                $requestStock,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->requestStocks()
                ->where('request_stocks.id', $requestStock->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_request_stocks_from_product()
    {
        $product = Product::factory()->create();
        $requestStock = RequestStock::factory()->create();

        $response = $this->deleteJson(
            route('api.products.request-stocks.store', [
                $product,
                $requestStock,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->requestStocks()
                ->where('request_stocks.id', $requestStock->id)
                ->exists()
        );
    }
}

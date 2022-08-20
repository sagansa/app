<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\RemainingStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRemainingStocksTest extends TestCase
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
    public function it_gets_product_remaining_stocks()
    {
        $product = Product::factory()->create();
        $remainingStock = RemainingStock::factory()->create();

        $product->remainingStocks()->attach($remainingStock);

        $response = $this->getJson(
            route('api.products.remaining-stocks.index', $product)
        );

        $response->assertOk()->assertSee($remainingStock->date);
    }

    /**
     * @test
     */
    public function it_can_attach_remaining_stocks_to_product()
    {
        $product = Product::factory()->create();
        $remainingStock = RemainingStock::factory()->create();

        $response = $this->postJson(
            route('api.products.remaining-stocks.store', [
                $product,
                $remainingStock,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->remainingStocks()
                ->where('remaining_stocks.id', $remainingStock->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_remaining_stocks_from_product()
    {
        $product = Product::factory()->create();
        $remainingStock = RemainingStock::factory()->create();

        $response = $this->deleteJson(
            route('api.products.remaining-stocks.store', [
                $product,
                $remainingStock,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->remainingStocks()
                ->where('remaining_stocks.id', $remainingStock->id)
                ->exists()
        );
    }
}

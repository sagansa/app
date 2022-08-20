<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\TransferStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferStockProductsTest extends TestCase
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
    public function it_gets_transfer_stock_products()
    {
        $transferStock = TransferStock::factory()->create();
        $product = Product::factory()->create();

        $transferStock->products()->attach($product);

        $response = $this->getJson(
            route('api.transfer-stocks.products.index', $transferStock)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_transfer_stock()
    {
        $transferStock = TransferStock::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.transfer-stocks.products.store', [
                $transferStock,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $transferStock
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_transfer_stock()
    {
        $transferStock = TransferStock::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.transfer-stocks.products.store', [
                $transferStock,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $transferStock
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

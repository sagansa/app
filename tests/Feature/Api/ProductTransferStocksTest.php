<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\TransferStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTransferStocksTest extends TestCase
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
    public function it_gets_product_transfer_stocks()
    {
        $product = Product::factory()->create();
        $transferStock = TransferStock::factory()->create();

        $product->transferStocks()->attach($transferStock);

        $response = $this->getJson(
            route('api.products.transfer-stocks.index', $product)
        );

        $response->assertOk()->assertSee($transferStock->date);
    }

    /**
     * @test
     */
    public function it_can_attach_transfer_stocks_to_product()
    {
        $product = Product::factory()->create();
        $transferStock = TransferStock::factory()->create();

        $response = $this->postJson(
            route('api.products.transfer-stocks.store', [
                $product,
                $transferStock,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->transferStocks()
                ->where('transfer_stocks.id', $transferStock->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_transfer_stocks_from_product()
    {
        $product = Product::factory()->create();
        $transferStock = TransferStock::factory()->create();

        $response = $this->deleteJson(
            route('api.products.transfer-stocks.store', [
                $product,
                $transferStock,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->transferStocks()
                ->where('transfer_stocks.id', $transferStock->id)
                ->exists()
        );
    }
}

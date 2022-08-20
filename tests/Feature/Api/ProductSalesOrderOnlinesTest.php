<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\SalesOrderOnline;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSalesOrderOnlinesTest extends TestCase
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
    public function it_gets_product_sales_order_onlines()
    {
        $product = Product::factory()->create();
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $product->salesOrderOnlines()->attach($salesOrderOnline);

        $response = $this->getJson(
            route('api.products.sales-order-onlines.index', $product)
        );

        $response->assertOk()->assertSee($salesOrderOnline->image);
    }

    /**
     * @test
     */
    public function it_can_attach_sales_order_onlines_to_product()
    {
        $product = Product::factory()->create();
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $response = $this->postJson(
            route('api.products.sales-order-onlines.store', [
                $product,
                $salesOrderOnline,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->salesOrderOnlines()
                ->where('sales_order_onlines.id', $salesOrderOnline->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_sales_order_onlines_from_product()
    {
        $product = Product::factory()->create();
        $salesOrderOnline = SalesOrderOnline::factory()->create();

        $response = $this->deleteJson(
            route('api.products.sales-order-onlines.store', [
                $product,
                $salesOrderOnline,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->salesOrderOnlines()
                ->where('sales_order_onlines.id', $salesOrderOnline->id)
                ->exists()
        );
    }
}

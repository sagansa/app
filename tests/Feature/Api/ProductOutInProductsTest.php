<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\OutInProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductOutInProductsTest extends TestCase
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
    public function it_gets_product_out_in_products()
    {
        $product = Product::factory()->create();
        $outInProduct = OutInProduct::factory()->create();

        $product->outInProducts()->attach($outInProduct);

        $response = $this->getJson(
            route('api.products.out-in-products.index', $product)
        );

        $response->assertOk()->assertSee($outInProduct->image);
    }

    /**
     * @test
     */
    public function it_can_attach_out_in_products_to_product()
    {
        $product = Product::factory()->create();
        $outInProduct = OutInProduct::factory()->create();

        $response = $this->postJson(
            route('api.products.out-in-products.store', [
                $product,
                $outInProduct,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->outInProducts()
                ->where('out_in_products.id', $outInProduct->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_out_in_products_from_product()
    {
        $product = Product::factory()->create();
        $outInProduct = OutInProduct::factory()->create();

        $response = $this->deleteJson(
            route('api.products.out-in-products.store', [
                $product,
                $outInProduct,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->outInProducts()
                ->where('out_in_products.id', $outInProduct->id)
                ->exists()
        );
    }
}

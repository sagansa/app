<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\OutInProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OutInProductProductsTest extends TestCase
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
    public function it_gets_out_in_product_products()
    {
        $outInProduct = OutInProduct::factory()->create();
        $product = Product::factory()->create();

        $outInProduct->products()->attach($product);

        $response = $this->getJson(
            route('api.out-in-products.products.index', $outInProduct)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_out_in_product()
    {
        $outInProduct = OutInProduct::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.out-in-products.products.store', [
                $outInProduct,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $outInProduct
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_out_in_product()
    {
        $outInProduct = OutInProduct::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.out-in-products.products.store', [
                $outInProduct,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $outInProduct
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

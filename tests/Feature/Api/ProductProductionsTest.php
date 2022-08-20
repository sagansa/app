<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductionsTest extends TestCase
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
    public function it_gets_product_productions()
    {
        $product = Product::factory()->create();
        $production = Production::factory()->create();

        $product->productions()->attach($production);

        $response = $this->getJson(
            route('api.products.productions.index', $product)
        );

        $response->assertOk()->assertSee($production->date);
    }

    /**
     * @test
     */
    public function it_can_attach_productions_to_product()
    {
        $product = Product::factory()->create();
        $production = Production::factory()->create();

        $response = $this->postJson(
            route('api.products.productions.store', [$product, $production])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->productions()
                ->where('productions.id', $production->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_productions_from_product()
    {
        $product = Product::factory()->create();
        $production = Production::factory()->create();

        $response = $this->deleteJson(
            route('api.products.productions.store', [$product, $production])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->productions()
                ->where('productions.id', $production->id)
                ->exists()
        );
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\SelfConsumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SelfConsumptionProductsTest extends TestCase
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
    public function it_gets_self_consumption_products()
    {
        $selfConsumption = SelfConsumption::factory()->create();
        $product = Product::factory()->create();

        $selfConsumption->products()->attach($product);

        $response = $this->getJson(
            route('api.self-consumptions.products.index', $selfConsumption)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_self_consumption()
    {
        $selfConsumption = SelfConsumption::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.self-consumptions.products.store', [
                $selfConsumption,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $selfConsumption
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_self_consumption()
    {
        $selfConsumption = SelfConsumption::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.self-consumptions.products.store', [
                $selfConsumption,
                $product,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $selfConsumption
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

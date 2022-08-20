<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Consumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductConsumptionsTest extends TestCase
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
    public function it_gets_product_consumptions()
    {
        $product = Product::factory()->create();
        $consumption = Consumption::factory()->create();

        $product->consumptions()->attach($consumption);

        $response = $this->getJson(
            route('api.products.consumptions.index', $product)
        );

        $response->assertOk()->assertSee($consumption->date);
    }

    /**
     * @test
     */
    public function it_can_attach_consumptions_to_product()
    {
        $product = Product::factory()->create();
        $consumption = Consumption::factory()->create();

        $response = $this->postJson(
            route('api.products.consumptions.store', [$product, $consumption])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->consumptions()
                ->where('consumptions.id', $consumption->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_consumptions_from_product()
    {
        $product = Product::factory()->create();
        $consumption = Consumption::factory()->create();

        $response = $this->deleteJson(
            route('api.products.consumptions.store', [$product, $consumption])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->consumptions()
                ->where('consumptions.id', $consumption->id)
                ->exists()
        );
    }
}

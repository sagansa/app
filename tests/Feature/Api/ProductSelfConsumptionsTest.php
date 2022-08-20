<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\SelfConsumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSelfConsumptionsTest extends TestCase
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
    public function it_gets_product_self_consumptions()
    {
        $product = Product::factory()->create();
        $selfConsumption = SelfConsumption::factory()->create();

        $product->selfConsumptions()->attach($selfConsumption);

        $response = $this->getJson(
            route('api.products.self-consumptions.index', $product)
        );

        $response->assertOk()->assertSee($selfConsumption->date);
    }

    /**
     * @test
     */
    public function it_can_attach_self_consumptions_to_product()
    {
        $product = Product::factory()->create();
        $selfConsumption = SelfConsumption::factory()->create();

        $response = $this->postJson(
            route('api.products.self-consumptions.store', [
                $product,
                $selfConsumption,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->selfConsumptions()
                ->where('self_consumptions.id', $selfConsumption->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_self_consumptions_from_product()
    {
        $product = Product::factory()->create();
        $selfConsumption = SelfConsumption::factory()->create();

        $response = $this->deleteJson(
            route('api.products.self-consumptions.store', [
                $product,
                $selfConsumption,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->selfConsumptions()
                ->where('self_consumptions.id', $selfConsumption->id)
                ->exists()
        );
    }
}

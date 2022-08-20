<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Unit;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitProductsTest extends TestCase
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
    public function it_gets_unit_products()
    {
        $unit = Unit::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'unit_id' => $unit->id,
            ]);

        $response = $this->getJson(route('api.units.products.index', $unit));

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_unit_products()
    {
        $unit = Unit::factory()->create();
        $data = Product::factory()
            ->make([
                'unit_id' => $unit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.units.products.store', $unit),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($unit->id, $product->unit_id);
    }
}

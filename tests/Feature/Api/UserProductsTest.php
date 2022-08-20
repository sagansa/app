<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProductsTest extends TestCase
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
    public function it_gets_user_products()
    {
        $user = User::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.products.index', $user));

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_products()
    {
        $user = User::factory()->create();
        $data = Product::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.products.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($user->id, $product->user_id);
    }
}

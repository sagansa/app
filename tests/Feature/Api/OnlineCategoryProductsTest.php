<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\OnlineCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnlineCategoryProductsTest extends TestCase
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
    public function it_gets_online_category_products()
    {
        $onlineCategory = OnlineCategory::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'online_category_id' => $onlineCategory->id,
            ]);

        $response = $this->getJson(
            route('api.online-categories.products.index', $onlineCategory)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_online_category_products()
    {
        $onlineCategory = OnlineCategory::factory()->create();
        $data = Product::factory()
            ->make([
                'online_category_id' => $onlineCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.online-categories.products.store', $onlineCategory),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($onlineCategory->id, $product->online_category_id);
    }
}

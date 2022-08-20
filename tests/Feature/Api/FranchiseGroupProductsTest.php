<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\FranchiseGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FranchiseGroupProductsTest extends TestCase
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
    public function it_gets_franchise_group_products()
    {
        $franchiseGroup = FranchiseGroup::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'franchise_group_id' => $franchiseGroup->id,
            ]);

        $response = $this->getJson(
            route('api.franchise-groups.products.index', $franchiseGroup)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_franchise_group_products()
    {
        $franchiseGroup = FranchiseGroup::factory()->create();
        $data = Product::factory()
            ->make([
                'franchise_group_id' => $franchiseGroup->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.franchise-groups.products.store', $franchiseGroup),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($franchiseGroup->id, $product->franchise_group_id);
    }
}

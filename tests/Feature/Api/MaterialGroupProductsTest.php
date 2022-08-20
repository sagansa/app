<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\MaterialGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialGroupProductsTest extends TestCase
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
    public function it_gets_material_group_products()
    {
        $materialGroup = MaterialGroup::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'material_group_id' => $materialGroup->id,
            ]);

        $response = $this->getJson(
            route('api.material-groups.products.index', $materialGroup)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_material_group_products()
    {
        $materialGroup = MaterialGroup::factory()->create();
        $data = Product::factory()
            ->make([
                'material_group_id' => $materialGroup->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.material-groups.products.store', $materialGroup),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($materialGroup->id, $product->material_group_id);
    }
}

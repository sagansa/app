<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Product;

use App\Models\Unit;
use App\Models\PaymentType;
use App\Models\ProductGroup;
use App\Models\MaterialGroup;
use App\Models\FranchiseGroup;
use App\Models\OnlineCategory;
use App\Models\RestaurantCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_products()
    {
        $products = Product::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('products.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.products.index')
            ->assertViewHas('products');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_product()
    {
        $response = $this->get(route('products.create'));

        $response->assertOk()->assertViewIs('app.products.create');
    }

    /**
     * @test
     */
    public function it_stores_the_product()
    {
        $data = Product::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('products.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $product = Product::latest('id')->first();

        $response->assertRedirect(route('products.edit', $product));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_product()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response
            ->assertOk()
            ->assertViewIs('app.products.show')
            ->assertViewHas('product');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_product()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product));

        $response
            ->assertOk()
            ->assertViewIs('app.products.edit')
            ->assertViewHas('product');
    }

    /**
     * @test
     */
    public function it_updates_the_product()
    {
        $product = Product::factory()->create();

        $user = User::factory()->create();
        $unit = Unit::factory()->create();
        $materialGroup = MaterialGroup::factory()->create();
        $franchiseGroup = FranchiseGroup::factory()->create();
        $paymentType = PaymentType::factory()->create();
        $onlineCategory = OnlineCategory::factory()->create();
        $productGroup = ProductGroup::factory()->create();
        $restaurantCategory = RestaurantCategory::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'slug' => $this->faker->text(50),
            'sku' => $this->faker->text(255),
            'barcode' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'request' => $this->faker->numberBetween(1, 2),
            'remaining' => $this->faker->numberBetween(1, 2),
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'material_group_id' => $materialGroup->id,
            'franchise_group_id' => $franchiseGroup->id,
            'payment_type_id' => $paymentType->id,
            'online_category_id' => $onlineCategory->id,
            'product_group_id' => $productGroup->id,
            'restaurant_category_id' => $restaurantCategory->id,
        ];

        $response = $this->put(route('products.update', $product), $data);

        unset($data['user_id']);

        $data['id'] = $product->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertRedirect(route('products.edit', $product));
    }

    /**
     * @test
     */
    public function it_deletes_the_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));

        $this->assertSoftDeleted($product);
    }
}

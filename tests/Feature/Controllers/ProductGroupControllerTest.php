<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ProductGroup;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductGroupControllerTest extends TestCase
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
    public function it_displays_index_view_with_product_groups()
    {
        $productGroups = ProductGroup::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('product-groups.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.product_groups.index')
            ->assertViewHas('productGroups');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_product_group()
    {
        $response = $this->get(route('product-groups.create'));

        $response->assertOk()->assertViewIs('app.product_groups.create');
    }

    /**
     * @test
     */
    public function it_stores_the_product_group()
    {
        $data = ProductGroup::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('product-groups.store'), $data);

        $this->assertDatabaseHas('product_groups', $data);

        $productGroup = ProductGroup::latest('id')->first();

        $response->assertRedirect(route('product-groups.edit', $productGroup));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_product_group()
    {
        $productGroup = ProductGroup::factory()->create();

        $response = $this->get(route('product-groups.show', $productGroup));

        $response
            ->assertOk()
            ->assertViewIs('app.product_groups.show')
            ->assertViewHas('productGroup');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_product_group()
    {
        $productGroup = ProductGroup::factory()->create();

        $response = $this->get(route('product-groups.edit', $productGroup));

        $response
            ->assertOk()
            ->assertViewIs('app.product_groups.edit')
            ->assertViewHas('productGroup');
    }

    /**
     * @test
     */
    public function it_updates_the_product_group()
    {
        $productGroup = ProductGroup::factory()->create();

        $data = [
            'name' => $this->faker->text(50),
        ];

        $response = $this->put(
            route('product-groups.update', $productGroup),
            $data
        );

        $data['id'] = $productGroup->id;

        $this->assertDatabaseHas('product_groups', $data);

        $response->assertRedirect(route('product-groups.edit', $productGroup));
    }

    /**
     * @test
     */
    public function it_deletes_the_product_group()
    {
        $productGroup = ProductGroup::factory()->create();

        $response = $this->delete(
            route('product-groups.destroy', $productGroup)
        );

        $response->assertRedirect(route('product-groups.index'));

        $this->assertModelMissing($productGroup);
    }
}

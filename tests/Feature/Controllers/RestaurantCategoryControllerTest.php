<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RestaurantCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestaurantCategoryControllerTest extends TestCase
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
    public function it_displays_index_view_with_restaurant_categories()
    {
        $restaurantCategories = RestaurantCategory::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('restaurant-categories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.restaurant_categories.index')
            ->assertViewHas('restaurantCategories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_restaurant_category()
    {
        $response = $this->get(route('restaurant-categories.create'));

        $response->assertOk()->assertViewIs('app.restaurant_categories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_restaurant_category()
    {
        $data = RestaurantCategory::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('restaurant-categories.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('restaurant_categories', $data);

        $restaurantCategory = RestaurantCategory::latest('id')->first();

        $response->assertRedirect(
            route('restaurant-categories.edit', $restaurantCategory)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_restaurant_category()
    {
        $restaurantCategory = RestaurantCategory::factory()->create();

        $response = $this->get(
            route('restaurant-categories.show', $restaurantCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.restaurant_categories.show')
            ->assertViewHas('restaurantCategory');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_restaurant_category()
    {
        $restaurantCategory = RestaurantCategory::factory()->create();

        $response = $this->get(
            route('restaurant-categories.edit', $restaurantCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.restaurant_categories.edit')
            ->assertViewHas('restaurantCategory');
    }

    /**
     * @test
     */
    public function it_updates_the_restaurant_category()
    {
        $restaurantCategory = RestaurantCategory::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->text(50),
            'user_id' => $user->id,
        ];

        $response = $this->put(
            route('restaurant-categories.update', $restaurantCategory),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $restaurantCategory->id;

        $this->assertDatabaseHas('restaurant_categories', $data);

        $response->assertRedirect(
            route('restaurant-categories.edit', $restaurantCategory)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_restaurant_category()
    {
        $restaurantCategory = RestaurantCategory::factory()->create();

        $response = $this->delete(
            route('restaurant-categories.destroy', $restaurantCategory)
        );

        $response->assertRedirect(route('restaurant-categories.index'));

        $this->assertModelMissing($restaurantCategory);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RestaurantCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestaurantCategoryTest extends TestCase
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
    public function it_gets_restaurant_categories_list()
    {
        $restaurantCategories = RestaurantCategory::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.restaurant-categories.index'));

        $response->assertOk()->assertSee($restaurantCategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_restaurant_category()
    {
        $data = RestaurantCategory::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.restaurant-categories.store'),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('restaurant_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.restaurant-categories.update', $restaurantCategory),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $restaurantCategory->id;

        $this->assertDatabaseHas('restaurant_categories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_restaurant_category()
    {
        $restaurantCategory = RestaurantCategory::factory()->create();

        $response = $this->deleteJson(
            route('api.restaurant-categories.destroy', $restaurantCategory)
        );

        $this->assertModelMissing($restaurantCategory);

        $response->assertNoContent();
    }
}

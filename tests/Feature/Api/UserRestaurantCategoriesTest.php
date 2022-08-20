<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RestaurantCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRestaurantCategoriesTest extends TestCase
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
    public function it_gets_user_restaurant_categories()
    {
        $user = User::factory()->create();
        $restaurantCategories = RestaurantCategory::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.restaurant-categories.index', $user)
        );

        $response->assertOk()->assertSee($restaurantCategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_restaurant_categories()
    {
        $user = User::factory()->create();
        $data = RestaurantCategory::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.restaurant-categories.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('restaurant_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $restaurantCategory = RestaurantCategory::latest('id')->first();

        $this->assertEquals($user->id, $restaurantCategory->user_id);
    }
}

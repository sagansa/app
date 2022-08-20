<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\OnlineCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnlineCategoryTest extends TestCase
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
    public function it_gets_online_categories_list()
    {
        $onlineCategories = OnlineCategory::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.online-categories.index'));

        $response->assertOk()->assertSee($onlineCategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_online_category()
    {
        $data = OnlineCategory::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.online-categories.store'),
            $data
        );

        $this->assertDatabaseHas('online_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_online_category()
    {
        $onlineCategory = OnlineCategory::factory()->create();

        $data = [
            'name' => $this->faker->text(50),
            'status' => $this->faker->numberBetween(1, 2),
        ];

        $response = $this->putJson(
            route('api.online-categories.update', $onlineCategory),
            $data
        );

        $data['id'] = $onlineCategory->id;

        $this->assertDatabaseHas('online_categories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_online_category()
    {
        $onlineCategory = OnlineCategory::factory()->create();

        $response = $this->deleteJson(
            route('api.online-categories.destroy', $onlineCategory)
        );

        $this->assertModelMissing($onlineCategory);

        $response->assertNoContent();
    }
}

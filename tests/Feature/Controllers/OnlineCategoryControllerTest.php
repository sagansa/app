<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\OnlineCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnlineCategoryControllerTest extends TestCase
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
    public function it_displays_index_view_with_online_categories()
    {
        $onlineCategories = OnlineCategory::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('online-categories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.online_categories.index')
            ->assertViewHas('onlineCategories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_online_category()
    {
        $response = $this->get(route('online-categories.create'));

        $response->assertOk()->assertViewIs('app.online_categories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_online_category()
    {
        $data = OnlineCategory::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('online-categories.store'), $data);

        $this->assertDatabaseHas('online_categories', $data);

        $onlineCategory = OnlineCategory::latest('id')->first();

        $response->assertRedirect(
            route('online-categories.edit', $onlineCategory)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_online_category()
    {
        $onlineCategory = OnlineCategory::factory()->create();

        $response = $this->get(
            route('online-categories.show', $onlineCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.online_categories.show')
            ->assertViewHas('onlineCategory');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_online_category()
    {
        $onlineCategory = OnlineCategory::factory()->create();

        $response = $this->get(
            route('online-categories.edit', $onlineCategory)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.online_categories.edit')
            ->assertViewHas('onlineCategory');
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

        $response = $this->put(
            route('online-categories.update', $onlineCategory),
            $data
        );

        $data['id'] = $onlineCategory->id;

        $this->assertDatabaseHas('online_categories', $data);

        $response->assertRedirect(
            route('online-categories.edit', $onlineCategory)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_online_category()
    {
        $onlineCategory = OnlineCategory::factory()->create();

        $response = $this->delete(
            route('online-categories.destroy', $onlineCategory)
        );

        $response->assertRedirect(route('online-categories.index'));

        $this->assertModelMissing($onlineCategory);
    }
}

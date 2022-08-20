<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Utility;

use App\Models\Unit;
use App\Models\Store;
use App\Models\UtilityProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityControllerTest extends TestCase
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
    public function it_displays_index_view_with_utilities()
    {
        $utilities = Utility::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('utilities.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.utilities.index')
            ->assertViewHas('utilities');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_utility()
    {
        $response = $this->get(route('utilities.create'));

        $response->assertOk()->assertViewIs('app.utilities.create');
    }

    /**
     * @test
     */
    public function it_stores_the_utility()
    {
        $data = Utility::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('utilities.store'), $data);

        $this->assertDatabaseHas('utilities', $data);

        $utility = Utility::latest('id')->first();

        $response->assertRedirect(route('utilities.edit', $utility));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_utility()
    {
        $utility = Utility::factory()->create();

        $response = $this->get(route('utilities.show', $utility));

        $response
            ->assertOk()
            ->assertViewIs('app.utilities.show')
            ->assertViewHas('utility');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_utility()
    {
        $utility = Utility::factory()->create();

        $response = $this->get(route('utilities.edit', $utility));

        $response
            ->assertOk()
            ->assertViewIs('app.utilities.edit')
            ->assertViewHas('utility');
    }

    /**
     * @test
     */
    public function it_updates_the_utility()
    {
        $utility = Utility::factory()->create();

        $unit = Unit::factory()->create();
        $utilityProvider = UtilityProvider::factory()->create();
        $store = Store::factory()->create();

        $data = [
            'number' => $this->faker->randomNumber(),
            'name' => $this->faker->name,
            'category' => $this->faker->numberBetween(1, 3),
            'pre_post' => $this->faker->numberBetween(1, 2),
            'status' => $this->faker->numberBetween(1, 2),
            'unit_id' => $unit->id,
            'utility_provider_id' => $utilityProvider->id,
            'store_id' => $store->id,
        ];

        $response = $this->put(route('utilities.update', $utility), $data);

        $data['id'] = $utility->id;

        $this->assertDatabaseHas('utilities', $data);

        $response->assertRedirect(route('utilities.edit', $utility));
    }

    /**
     * @test
     */
    public function it_deletes_the_utility()
    {
        $utility = Utility::factory()->create();

        $response = $this->delete(route('utilities.destroy', $utility));

        $response->assertRedirect(route('utilities.index'));

        $this->assertModelMissing($utility);
    }
}

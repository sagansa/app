<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UtilityProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityProviderControllerTest extends TestCase
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
    public function it_displays_index_view_with_utility_providers()
    {
        $utilityProviders = UtilityProvider::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('utility-providers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.utility_providers.index')
            ->assertViewHas('utilityProviders');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_utility_provider()
    {
        $response = $this->get(route('utility-providers.create'));

        $response->assertOk()->assertViewIs('app.utility_providers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_utility_provider()
    {
        $data = UtilityProvider::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('utility-providers.store'), $data);

        $this->assertDatabaseHas('utility_providers', $data);

        $utilityProvider = UtilityProvider::latest('id')->first();

        $response->assertRedirect(
            route('utility-providers.edit', $utilityProvider)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_utility_provider()
    {
        $utilityProvider = UtilityProvider::factory()->create();

        $response = $this->get(
            route('utility-providers.show', $utilityProvider)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.utility_providers.show')
            ->assertViewHas('utilityProvider');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_utility_provider()
    {
        $utilityProvider = UtilityProvider::factory()->create();

        $response = $this->get(
            route('utility-providers.edit', $utilityProvider)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.utility_providers.edit')
            ->assertViewHas('utilityProvider');
    }

    /**
     * @test
     */
    public function it_updates_the_utility_provider()
    {
        $utilityProvider = UtilityProvider::factory()->create();

        $data = [
            'name' => $this->faker->text(20),
            'category' => $this->faker->numberBetween(1, 3),
        ];

        $response = $this->put(
            route('utility-providers.update', $utilityProvider),
            $data
        );

        $data['id'] = $utilityProvider->id;

        $this->assertDatabaseHas('utility_providers', $data);

        $response->assertRedirect(
            route('utility-providers.edit', $utilityProvider)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_utility_provider()
    {
        $utilityProvider = UtilityProvider::factory()->create();

        $response = $this->delete(
            route('utility-providers.destroy', $utilityProvider)
        );

        $response->assertRedirect(route('utility-providers.index'));

        $this->assertModelMissing($utilityProvider);
    }
}

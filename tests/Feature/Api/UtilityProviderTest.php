<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UtilityProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityProviderTest extends TestCase
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
    public function it_gets_utility_providers_list()
    {
        $utilityProviders = UtilityProvider::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.utility-providers.index'));

        $response->assertOk()->assertSee($utilityProviders[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_utility_provider()
    {
        $data = UtilityProvider::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.utility-providers.store'),
            $data
        );

        $this->assertDatabaseHas('utility_providers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.utility-providers.update', $utilityProvider),
            $data
        );

        $data['id'] = $utilityProvider->id;

        $this->assertDatabaseHas('utility_providers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_utility_provider()
    {
        $utilityProvider = UtilityProvider::factory()->create();

        $response = $this->deleteJson(
            route('api.utility-providers.destroy', $utilityProvider)
        );

        $this->assertModelMissing($utilityProvider);

        $response->assertNoContent();
    }
}

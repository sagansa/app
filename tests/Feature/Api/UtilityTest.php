<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Utility;

use App\Models\Unit;
use App\Models\Store;
use App\Models\UtilityProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityTest extends TestCase
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
    public function it_gets_utilities_list()
    {
        $utilities = Utility::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.utilities.index'));

        $response->assertOk()->assertSee($utilities[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_utility()
    {
        $data = Utility::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.utilities.store'), $data);

        $this->assertDatabaseHas('utilities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.utilities.update', $utility),
            $data
        );

        $data['id'] = $utility->id;

        $this->assertDatabaseHas('utilities', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_utility()
    {
        $utility = Utility::factory()->create();

        $response = $this->deleteJson(route('api.utilities.destroy', $utility));

        $this->assertModelMissing($utility);

        $response->assertNoContent();
    }
}

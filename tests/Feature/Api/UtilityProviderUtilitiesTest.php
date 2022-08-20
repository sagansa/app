<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Utility;
use App\Models\UtilityProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityProviderUtilitiesTest extends TestCase
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
    public function it_gets_utility_provider_utilities()
    {
        $utilityProvider = UtilityProvider::factory()->create();
        $utilities = Utility::factory()
            ->count(2)
            ->create([
                'utility_provider_id' => $utilityProvider->id,
            ]);

        $response = $this->getJson(
            route('api.utility-providers.utilities.index', $utilityProvider)
        );

        $response->assertOk()->assertSee($utilities[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_utility_provider_utilities()
    {
        $utilityProvider = UtilityProvider::factory()->create();
        $data = Utility::factory()
            ->make([
                'utility_provider_id' => $utilityProvider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.utility-providers.utilities.store', $utilityProvider),
            $data
        );

        $this->assertDatabaseHas('utilities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utility = Utility::latest('id')->first();

        $this->assertEquals(
            $utilityProvider->id,
            $utility->utility_provider_id
        );
    }
}
